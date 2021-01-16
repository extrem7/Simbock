<?php

namespace Modules\Frontend\Http\Controllers\Company;

use App\Models\Vacancy;
use App\Models\Volunteers\Volunteer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Repositories\VolunteerRepository;

class BoardController extends Controller
{
    use HasCompany;

    protected VolunteerRepository $repository;

    public function __construct()
    {
        $this->repository = app(VolunteerRepository::class);
    }

    public function __invoke()
    {
        $this->seo()->setTitle("Board | Company");

        $company = $this->company();
        $volunteers = collect();
        $vacancies = $company->vacancies()->with(['city', 'hours', 'type'])->get();

        $titles = $cities = $vacancies->pluck('title')->unique();
        $sectors = $cities = $vacancies->pluck('sector_id')->unique();
        $cities = $vacancies->pluck('city_id')->unique();
        $types = $vacancies->pluck('type_id')->unique();
        $hours = $vacancies->pluck('hours')->flatten()->pluck('id')->unique();
        $isRelocation = $vacancies->pluck('is_relocation')->flatten()->contains(true);
        $isRemoteWork = $vacancies->pluck('is_remote_work')->flatten()->contains(true);

        if ($company->subscribed()) {
            $volunteers = Volunteer::with(['user', 'types', 'hours', 'roles'])
                ->when($isRelocation, fn($q) => $q->where('is_relocating', '=', true))
                ->when($isRemoteWork, fn($q) => $q->where('is_working_remotely', '=', true))
                ->where(function (Builder $q) use ($titles, $sectors, $cities, $types, $hours) {
                    $titles->each(fn($t) => $q->where(
                        'job_title', 'REGEXP', '[[:<:]]' . $t . '[[:>:]]'
                    ));
                    $q->orWhereHas('roles', fn($q) => $q->whereIn('sector_id', $sectors));
                    $q->orWhereHas('locations', fn($q) => $q->whereIn('city_id', $cities));
                    $q->orWhereHas('types', fn($q) => $q->whereIn('id', $types));
                    $q->orWhereHas('hours', fn($q) => $q->whereIn('id', $hours));
                })
                ->orderByDesc('completeness')
                ->paginate(5, ['volunteers.*']);

            /* @var $volunteers Collection<Volunteer> */
            $volunteers->transform([$this->repository, 'transformForIndex']);

            if ($availableCandidates = $company->getAvailableCandidatesCount()) {
                $current = $volunteers->currentPage() * $volunteers->perPage();
                if ($current >= $availableCandidates) {
                    $volunteers = $volunteers->toArray();
                    $volunteers['last_page'] = $volunteers['current_page'];
                }
            }

            if (request()->expectsJson()) {
                return $volunteers;
            }
        }

        $availableVolunteers = $company->getAvailableVolunteersCount();

        $resumeViews = [
            'viewed' => $company->resume_views,
            'available' => $availableVolunteers === -1 ? '∞' : $availableVolunteers
        ];

        $lastVacancies = $company->vacancies()
            ->latest()
            ->limit(3)
            ->get(['id', 'title', 'status', 'created_at'])
            ->map(function (Vacancy $vacancy) {
                $vacancy->days = $vacancy->created_at->diffInDays();
                return $vacancy;
            });

        $counts = [];
        $counts['active'] = $company->vacancies()->active()->count();
        $counts['draft'] = $company->vacancies()->draft()->count();
        $counts['closed'] = $company->vacancies()->closed()->count();

        share(compact('volunteers', 'resumeViews', 'lastVacancies', 'counts'));

        return view('frontend::company.board');
    }
}
