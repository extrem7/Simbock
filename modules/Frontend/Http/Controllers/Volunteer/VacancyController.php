<?php

namespace Modules\Frontend\Http\Controllers\Volunteer;

use App\Models\Vacancy;
use Illuminate\Support\Collection;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Controllers\Volunteer\Account\HasVolunteer;
use Modules\Frontend\Repositories\VacancyRepository;

class VacancyController extends Controller
{
    use HasVolunteer;

    protected VacancyRepository $repository;

    protected $fields = [
        'id', 'company_id', 'title', 'city_id', 'type_id', 'excerpt', 'company_title', 'status', 'created_at'
    ];

    public function __construct()
    {
        $this->repository = app(VacancyRepository::class);
    }

    public function saved()
    {
        $this->seo()->setTitle("Saved vacancies");

        $vacancies = $this->volunteer()->bookmarks()
            ->active()
            ->with(['company.logoMedia', 'city', 'type', 'hours'])
            ->latest()
            ->paginate(4, $this->fields);

        /* @var $vacancies Collection<Vacancy> */
        $vacancies->transform([$this->repository, 'transformForIndex']);

        if (request()->expectsJson()) {
            return $vacancies;
        }

        $this->repository->shareForFilter();

        share(compact('vacancies'));

        \Route2Class::addClass('page-with-search');

        return view('frontend::volunteer.vacancies.saved');
    }

    public function history()
    {
        $this->seo()->setTitle("History apply");

        $vacancies = $this->volunteer()->applies()
            ->with(['company.logoMedia', 'city', 'type', 'hours'])
            ->latest()
            ->paginate(4, $this->fields);

        /* @var $vacancies Collection<Vacancy> */
        $vacancies->transform([$this->repository, 'transformForIndex']);

        if (request()->expectsJson()) {
            return $vacancies;
        }

        $this->repository->shareForFilter();

        share(compact('vacancies'));

        \Route2Class::addClass('page-with-search');

        return view('frontend::volunteer.vacancies.history');
    }
}
