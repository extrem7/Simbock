<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Company;
use App\Models\Volunteers\Volunteer;
use App\Services\LocationService;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Modules\Frontend\Http\Controllers\Company\HasCompany;
use Modules\Frontend\Http\Requests\VacanciesRequest;
use Modules\Frontend\Repositories\VacancyRepository;
use Modules\Frontend\Repositories\VolunteerRepository;
use Route2Class;

class VolunteerController extends Controller
{
    use HasCompany;

    protected VolunteerRepository $repository;

    protected VacancyRepository $vacancyRepository;

    public function __construct()
    {
        $this->repository = app(VolunteerRepository::class);
        $this->vacancyRepository = app(VacancyRepository::class);
    }

    public function index(
        VacanciesRequest $request,
        LocationService $locationService,
        string $query = null,
        string $location = null
    )
    {
        $title = $query ?? 'Search';
        $locations = [];

        if ($location) {
            $title .= " in $location";
            $locations = $locationService->parseLocation($location);
        }

        $this->seo()->setTitle("$title | Volunteers");

        $filters = $request->validated();

        $volunteers = Volunteer::when(
            $query,
            fn(Builder $q) => $q->where('job_title', 'REGEXP', '[[:<:]]' . $query . '[[:>:]]')
                ->orWhereHas('user',
                    fn(Builder $q) => $q->where('name', 'REGEXP', '[[:<:]]' . $query . '[[:>:]]')))
            ->when(!empty($locations),
                fn(Builder $q) => $q->whereHas('locations',
                    fn(Builder $q) => $q->whereIn('id', $locations)))
            ->with(['user', 'types', 'hours', 'roles'])
            ->when(isset($filters['is_relocation']), fn($q) => $q->where('is_relocation', '=', true))
            ->when(isset($filters['is_remote_work']), fn($q) => $q->where('is_remote_work', '=', true))
            ->when(isset($filters['hours']) && !empty($filters['hours']),
                fn($q) => $q->whereHas('hours', fn($q) => $q->whereIn('id', $filters['hours'])))
            ->when(isset($filters['types']) && !empty($filters['types']),
                fn($q) => $q->whereHas('types', fn($q) => $q->whereIn('id', $filters['types'])))
            ->when(isset($filters['sectors']) && !empty($filters['sectors']),
                fn($q) => $q->whereHas('roles', fn($q) => $q->whereIn('sector_id', $filters['sectors'])))
            ->when(isset($filters['time']),
                fn($q) => $q->whereHas('resume',
                    fn($q) => $q->where('created_at', '>=', Carbon::now()->subDays($filters['time'])->toDateTimeString()))
            )
            ->orderByDesc('completeness')
            ->paginate(4, ['volunteers.*']);

        /* @var $volunteers Collection<Volunteer> */
        $volunteers->transform([$this->repository, 'transformForIndex']);

        if (request()->expectsJson()) {
            return $volunteers;
        }

        $this->vacancyRepository->shareForFilter();
        share(compact('volunteers', 'query', 'location'));

        Route2Class::addClass('page-with-search');

        return view('frontend::company.volunteers.index');
    }

    public function saved()
    {
        $this->seo()->setTitle("Saved Candidates");

        $volunteers = Volunteer::whereIn('id', Auth::user()->company->bookmarks()->pluck('id'))
            ->with(['user', 'avatarMedia', 'city', 'types', 'hours', 'roles'])
            ->orderByDesc('completeness')
            ->paginate(4);

        /* @var $volunteers Collection<Volunteer> */
        $volunteers->transform([$this->repository, 'transformForIndex']);

        if (request()->expectsJson()) {
            return $volunteers;
        }

        $this->vacancyRepository->shareForFilter();
        share(compact('volunteers'));

        Route2Class::addClass('page-with-search');

        return view('frontend::company.volunteers.saved');
    }

    public function candidates()
    {
        $this->seo()->setTitle("View Candidates");
        $volunteers = Volunteer::whereIn('id', $this->company()->candidates()->pluck('id'))
            ->with(['user', 'avatarMedia', 'city', 'types', 'hours', 'roles'])
            ->orderByDesc('completeness')
            ->paginate(4);

        /* @var $volunteers Collection<Volunteer> */
        $volunteers->transform([$this->repository, 'transformForIndex']);

        if (request()->expectsJson()) {
            return $volunteers;
        }

        $this->vacancyRepository->shareForFilter();
        share(compact('volunteers'));

        Route2Class::addClass('page-with-search');

        return view('frontend::company.volunteers.candidates');
    }

    public function show(Volunteer $volunteer)
    {
        $this->seo()->setTitle("$volunteer->name | Volunteers");

        $volunteer = $this->repository->setupRelations($volunteer);
        $volunteer = $this->repository->setupAppends($volunteer);

        $this->repository->shareVolunteer($volunteer);
        $this->repository->shareForView();

        return view('frontend::company.volunteers.show');
    }

    public function self()
    {
        return $this->show(Auth::getUser()->volunteer);
    }

    public function bookmark(Volunteer $volunteer): JsonResponse
    {
        $bookmarks = Auth::user()->company->bookmarks()->toggle($volunteer->id);

        return response()->json([
            'message' => 'Volunteer has been ' .
                ($bookmarks['attached'] ? 'saved to' : 'removed from')
                . ' bookmarks.',
            'inBookmarks' => in_array($volunteer->id, $bookmarks['attached'], true)
        ]);
    }
}
