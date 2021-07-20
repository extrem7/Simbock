<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Chats\Chat;
use App\Models\Vacancy;
use App\Services\LocationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Modules\Frontend\Http\Controllers\Volunteer\Account\HasVolunteer;
use Modules\Frontend\Http\Requests\MessageRequest;
use Modules\Frontend\Http\Requests\VacanciesRequest;
use Modules\Frontend\Notifications\Company\VacancyApplied;
use Modules\Frontend\Repositories\VacancyRepository;

class VacancyController extends Controller
{
    use HasVolunteer;

    protected VacancyRepository $repository;

    public function __construct()
    {
        $this->repository = app(VacancyRepository::class);
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
            $locations = $locationService->parseLocation($location);
        }

        $this->seo()->setTitle(__('meta.vacancies.index.title'));
        $this->seo()->setDescription(__('meta.vacancies.index.description'));

        $filters = $request->validated();

        $vacancies = Vacancy::active()
            ->when($query, fn($q) => $q->where('title', 'REGEXP', '[[:<:]]' . $query . '[[:>:]]'))
            ->when(!empty($locations), fn(Builder $q) => $q->whereIn('city_id', $locations))
            ->with(['company.logoMedia', 'city', 'type', 'hours'])
            ->when(isset($filters['is_relocation']), fn($q) => $q->where('is_relocation', '=', true))
            ->when(isset($filters['is_remote_work']), fn($q) => $q->where('is_remote_work', '=', true))
            ->when(isset($filters['hours']) && !empty($filters['hours']),
                fn($q) => $q->whereHas('hours', fn($q) => $q->whereIn('id', $filters['hours'])))
            ->when(isset($filters['types']) && !empty($filters['types']),
                fn($q) => $q->whereIn('type_id', $filters['types']))
            ->when(isset($filters['sizes']) && !empty($filters['sizes']),
                fn($q) => $q->whereHas('company', fn($q) => $q->whereIn('size_id', $filters['sizes'])))
            ->when(isset($filters['sectors']) && !empty($filters['sectors']),
                fn($q) => $q->whereHas('sector', fn($q) => $q->whereIn('id', $filters['sectors'])))
            ->when(isset($filters['time']),
                fn($q) => $q->where('created_at', '>=',
                    Carbon::now()->subDays($filters['time'])->toDateTimeString()))
            ->latest()
            ->select([
                'id', 'company_id', 'title', 'city_id', 'address', 'type_id', 'excerpt', 'company_title', 'status',
                'created_at'
            ])
            ->paginate(4);

        /* @var $vacancies Collection<Vacancy> */
        $vacancies->transform([$this->repository, 'transformForIndex']);

        if (request()->expectsJson()) {
            return $vacancies;
        }

        $this->repository->shareForFilter();

        share(compact('vacancies', 'query', 'location'));

        \Route2Class::addClass('page-with-search');

        return view('frontend::vacancies.index');
    }

    public function show(Vacancy $vacancy)
    {
        if ($vacancy->status !== Vacancy::ACTIVE) {
            if (($user = \Auth::user()) && !$user->is_volunteer) {
                abort_if($vacancy->company_id !== $user->company->id, 404);
            } else {
                abort(404);
            }
        }

        $this->seo()->setTitle(__('meta.vacancies.show.title', ['name' => $vacancy->title]));
        $this->seo()->setDescription(__('meta.vacancies.show.description', [
            'name' => $vacancy->title,
            'location' => "{$vacancy->city->name}, {$vacancy->city->state_id} "
        ]));

        $vacancy->load('company.logoMedia', 'city', 'hours', 'benefits', 'incentives', 'skills');
        $vacancy->append(['employment', 'date', 'location', 'is_applied', 'in_bookmarks']);
        $vacancy->company_title ??= $vacancy->company->name;
        $vacancy->company_description ??= $vacancy->company->description;
        $vacancy->company->append('logo');

        share(compact('vacancy'));

        return view('frontend::vacancies.show');
    }

    public function apply(Vacancy $vacancy): JsonResponse
    {
        $volunteer = $this->volunteer();

        $volunteer->applies()->attach($vacancy->id);
        $vacancy->company->user->notify(new VacancyApplied($vacancy, $volunteer));

        return response()->json(['message' => 'Vacancy has been applied.']);
    }

    public function bookmark(Vacancy $vacancy): JsonResponse
    {
        $bookmarks = $this->volunteer()->bookmarks()->toggle($vacancy->id);

        return response()->json([
            'message' => 'Vacancy has been ' .
                ($bookmarks['attached'] ? 'saved to' : 'removed from')
                . ' bookmarks.',
            'inBookmarks' => in_array($vacancy->id, $bookmarks['attached'], true)
        ]);
    }

    public function chat(MessageRequest $request, Vacancy $vacancy): JsonResponse
    {
        $volunteer = $this->volunteer();
        /* @var $chat Chat */
        $chat = $volunteer->chats()->where('vacancy_id', '=', $vacancy->id)->first();
        if (!$chat) {
            $chat = $volunteer->chats()->create([
                'vacancy_id' => $vacancy->id,
                'company_id' => $vacancy->company_id
            ]);
        }
        $chat->messages()->create([
            'volunteer_id' => $volunteer->id,
            'text' => $request->input('message')
        ]);

        return response()->json(['message' => 'You message has been sent.'], 201);
    }
}
