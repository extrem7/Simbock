<?php

namespace Modules\Frontend\Http\Controllers\Company;

use App\Models\Vacancy;
use Auth;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Company\VacancyRequest;
use Modules\Frontend\Repositories\VacancyRepository;

class VacancyController extends Controller
{
    use HasCompany;

    protected VacancyRepository $repository;

    protected array $fillable = [
        'title', 'sector_id', 'city_id', 'address', 'type_id', 'description', 'is_relocation', 'is_remote_work',
        'company_title', 'company_description'
    ];

    public function __construct()
    {
        $this->repository = app(VacancyRepository::class);
    }

    public function index(string $status = null)
    {
        $this->seo()->setTitle('Volunteering Vacancies');

        $company = Auth::getUser()->company->append('logo');

        $vacancies = $company->vacancies()
            ->when($status, fn($q) => $q->where('status', $status))
            ->with(['city', 'type', 'hours'])
            ->latest()
            ->get(['id', 'company_id', 'title', 'city_id', 'type_id', 'excerpt', 'company_title', 'status', 'created_at'])
            ->map(function (Vacancy $vacancy) use ($company) {
                $vacancy->setRelation('company', $company);
                $vacancy->append(['employment', 'date', 'location']);

                $vacancy->company_title = $vacancy->company_title ?? $company->name;
                $vacancy->days = $vacancy->created_at->diffInDays();

                return $vacancy;
            });

        if ($status && !$vacancies->count()) {
            return redirect()->route('frontend.company.vacancies.index');
        }

        share(compact('vacancies'));

        $all = $company->vacancies()->count();
        $active = $company->vacancies()->active()->count();
        $draft = $company->vacancies()->draft()->count();
        $closed = $company->vacancies()->closed()->count();

        $availableVacancies = 0;
        if ($plan = $company->getPlan()) {
            $limit = $plan['limits']['vacancies'];
            $availableVacancies = $limit === -1 ? '∞' : $limit;
        }

        return view('frontend::company.vacancies.index', [
            'counts' => compact('all', 'active', 'draft', 'closed')
        ], compact('availableVacancies'));
    }

    public function create()
    {
        if (!$this->company()->subscribed()) {
            return redirect()->route('frontend.company.upgrade.page');
        }

        $title = 'Post vacancy';
        $this->seo()->setTitle($title);

        $this->repository->sharedData();

        return view('frontend::company.vacancies.form', compact('title'));
    }

    public function store(VacancyRequest $request): JsonResponse
    {
        $company = Auth::getUser()->company;

        if (!$company->canPostVacancy()) {
            return response()->json([
                'message' => 'You have exhausted the vacancy limit. Delete another vacancy or update your plan.'
            ], 403);
        }

        /* @var $vacancy Vacancy */
        $vacancy = $company->vacancies()->create($request->only($this->fillable));
        $request->setVacancy($vacancy);
        $request->syncHours();
        $request->syncBenefits();
        $request->syncIncentives();
        $request->syncSkills();

        return response()->json(['message' => 'Vacancy has been created.']);
    }

    public function edit(Vacancy $vacancy)
    {
        $title = 'Edit vacancy';
        $this->seo()->setTitle('Edit vacancy');

        $this->repository->sharedData();
        $vacancy = $this->repository->transformForEdit($vacancy);
        share(compact('vacancy'));

        return view('frontend::company.vacancies.form', compact('title'));
    }

    public function update(VacancyRequest $request, Vacancy $vacancy): JsonResponse
    {
        $vacancy->update($request->only($this->fillable));
        $request->setVacancy($vacancy);
        $request->syncHours();
        $request->syncBenefits();
        $request->syncIncentives();
        $request->syncSkills();

        return response()->json(['message' => 'Vacancy has been updated.']);
    }

    public function destroy(Vacancy $vacancy): JsonResponse
    {
        $vacancy->delete();
        return response()->json(['message' => 'The vacancy has been deleted.']);
    }

    public function post(Vacancy $vacancy): JsonResponse
    {
        //todo check subscription
        if (!in_array($vacancy->status, [Vacancy::DRAFT])) abort(403);
        $vacancy->status = Vacancy::ACTIVE;
        $vacancy->save();
        return response()->json(['message' => 'The vacancy has been published.']);
    }

    public function stop(Vacancy $vacancy): JsonResponse
    {
        $vacancy->status = Vacancy::DRAFT;
        $vacancy->save();
        return response()->json(['message' => 'The vacancy has been stopped.']);
    }

    public function close(Vacancy $vacancy): JsonResponse
    {
        if (!in_array($vacancy->status, [Vacancy::DRAFT, Vacancy::ACTIVE])) abort(403);
        $vacancy->status = Vacancy::CLOSED;
        $vacancy->save();
        return response()->json(['message' => 'The vacancy has been closed.']);
    }

    public function duplicate(Vacancy $vacancy)
    {
        $title = 'Duplicate vacancy';
        $this->seo()->setTitle($title);

        $this->repository->sharedData();

        share([
            'vacancy' => $this->repository->transformForEdit($vacancy)
        ]);

        return view('frontend::company.vacancies.form', compact('title'));
    }
}
