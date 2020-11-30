<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Map\US\City;
use App\Models\Map\US\State;
use App\Models\Vacancy;
use App\Services\LocationService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Controllers\Volunteer\Account\HasVolunteer;

class VacancyController extends Controller
{
    use HasVolunteer;

    public function index(LocationService $locationService, string $query = null, string $location = null)
    {
        $title = $query ?? 'Search';
        $locations = [];

        if ($location) {
            $title .= " in $location";
            $locations = $locationService->parseLocation($location);
        }

        $this->seo()->setTitle("$title | Vacancies");

        $vacancies = Vacancy::when($query, fn($q) => $q->where('title', 'REGEXP', '[[:<:]]' . $query . '[[:>:]]'))
            ->when(!empty($locations), fn(Builder $q) => $q->whereIn('city_id', $locations))
            ->with(['company.logoMedia', 'city', 'type', 'hours'])
            ->latest()
            ->paginate(
                4,
                ['id', 'company_id', 'title', 'city_id', 'type_id', 'excerpt', 'company_title', 'status', 'created_at']
            );

        $vacancies->transform(function (Vacancy $vacancy) {
            $vacancy->append(['employment', 'date', 'location', 'is_applied', 'in_bookmarks']);

            $vacancy->company_title = $vacancy->company_title ?? $vacancy->company->name;
            $vacancy->days = $vacancy->created_at->diffInDays();

            $vacancy->company->append('logo');

            return $vacancy;
        });

        if (request()->expectsJson()) {
            return $vacancies;
        }
        share(compact('vacancies', 'query', 'location'));

        return view('frontend::vacancies.index');
    }

    public function show(Vacancy $vacancy)
    {
        $this->seo()->setTitle("$vacancy->title | Vacancies");

        $vacancy->load('company.logoMedia', 'city', 'hours', 'benefits', 'incentives', 'skills');
        $vacancy->append(['employment', 'date', 'location']);
        $vacancy->company_title ??= $vacancy->company->name;
        $vacancy->company_description ??= $vacancy->company->description;
        $vacancy->company->append('logo');

        share(compact('vacancy'));

        return view('frontend::vacancies.show');
    }

    public function apply(Vacancy $vacancy): JsonResponse
    {
        $this->volunteer()->applies()->attach($vacancy->id);
        return response()->json(['message' => 'Vacancy has been applied.']);
    }

    public function bookmark(Vacancy $vacancy): JsonResponse
    {
        $bookmarks = $this->volunteer()->bookmarks()->toggle($vacancy->id);

        return response()->json([
            'message' => 'Vacancy has been saved to bookmarks.',
            'inBookmarks' => in_array($vacancy->id, $bookmarks['attached'], true)
        ]);
    }
}
