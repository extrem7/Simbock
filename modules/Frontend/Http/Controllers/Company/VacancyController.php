<?php

namespace Modules\Frontend\Http\Controllers\Company;

use App\Models\Jobs\Benefit;
use App\Models\Jobs\Hour;
use App\Models\Jobs\Incentive;
use App\Models\Jobs\Sector;
use App\Models\Jobs\Skill;
use App\Models\Jobs\Type;
use App\Models\Vacancy;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Company\VacancyRequest;

class VacancyController extends Controller
{
    protected array $fillable = [
        'title', 'sector_id', 'city_id', 'address', 'type_id', 'description', 'is_relocation', 'is_remote_work',
        'company_title', 'company_description'
    ];

    public function index()
    {
        $this->seo()->setTitle('Volunteering Vacancies');

        $company = \Auth::getUser()->company;

        $vacancies = \Auth::getUser()->company->vacancies()
            ->with(['city', 'type', 'hours'])
            ->get(['company_id', 'title', 'city_id', 'type_id', 'excerpt', 'company_title', 'status'])
            ->map(function (Vacancy $vacancy) use ($company) {
                $vacancy->setRelation('company', $company);
            });

        share(compact('vacancies'));

        return view('frontend::company.vacancies.index');
    }

    public function show(Vacancy $vacancy)
    {
        $vacancy->load('company');
        return $vacancy;
    }

    public function create()
    {
        $this->seo()->setTitle('Post vacancy');

        $sectors = Sector::all('name', 'id')->map(fn(Sector $s) => ['text' => $s->name, 'value' => $s->id]);
        $types = Type::all('name', 'id')->map(fn(Type $t) => ['text' => $t->name, 'value' => $t->id]);
        $hours = Hour::all('name', 'id')->map(fn(Hour $h) => ['text' => $h->name, 'value' => $h->id]);
        $benefits = Benefit::all('name', 'id')->map(fn(Benefit $b) => ['text' => $b->name, 'value' => $b->id]);

        $incentives = Incentive::all(['name', 'id'])->map(fn(Incentive $i) => ['text' => $i->name]);
        $skills = Skill::all(['name', 'id'])->map(fn(Skill $s) => ['text' => $s->name]);

        share(compact('sectors', 'types', 'hours', 'benefits', 'incentives', 'skills'));

        return view('frontend::company.vacancies.create');
    }

    public function store(VacancyRequest $request)
    {
        $company = \Auth::getUser()->company;

        /* @var $vacancy Vacancy */
        $vacancy = $company->vacancies()->create($request->only($this->fillable));
        $request->setVacancy($vacancy);
        $request->syncHours();
        $request->syncBenefits();
        $request->syncIncentives();
        $request->syncSkills();

        $vacancy->load('hours', 'benefits', 'incentives', 'skills');
        $vacancy = $vacancy->toArray();
        $vacancy['hours'] = collect($vacancy['hours'])->map(fn(array $h) => $h['id']);
        $vacancy['benefits'] = collect($vacancy['benefits'])->map(fn(array $b) => $b['id']);
        $vacancy['incentives'] = collect($vacancy['incentives'])->map(fn(array $i) => ['text' => $i['name']]);
        $vacancy['skills'] = collect($vacancy['skills'])->map(fn(array $s) => ['text' => $s['name']]);

        return response()->json(['message' => 'Vacancy has been created.', 'vacancy' => $vacancy]);
    }

    public function update(VacancyRequest $request, Vacancy $vacancy)
    {
        $vacancy->update($request->only($this->fillable));
        $request->setVacancy($vacancy);
        $request->syncHours();
        $request->syncBenefits();
        //todo incentives and skills
        return $vacancy;
    }

    public function post(Vacancy $vacancy)
    {
        //todo check subscription
        $vacancy->status = Vacancy::PUBLISHED;
        $vacancy->save();
        return response()->json(['The vacancy has been published.']);
    }

    public function stop(Vacancy $vacancy)
    {
        $vacancy->status = Vacancy::STOPPED;
        $vacancy->save();
        return response()->json(['The vacancy has been stopped.']);
    }

    public function close(Vacancy $vacancy)
    {
        $vacancy->status = Vacancy::CLOSED;
        $vacancy->save();
        return response()->json(['The vacancy has been closed.']);
    }

    public function duplicate(Vacancy $vacancy)
    {
        $vacancy->status = Vacancy::DRAFT;
    }

    public function delete(Vacancy $vacancy)
    {
        $vacancy->delete();
        return response()->json(['The vacancy has been deleted.']);
    }
}
