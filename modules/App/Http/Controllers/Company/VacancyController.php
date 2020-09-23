<?php

namespace Modules\App\Http\Controllers\Company;

use App\Models\Vacancy;
use Illuminate\Routing\Controller;
use Modules\App\Http\Requests\Company\VacancyRequest;

class VacancyController extends Controller
{
    protected array $fillable = [
        'title', 'sector_id', 'city_id', 'type_id', 'description', 'is_relocation', 'is_remote_work', 'address',
        'company_title', 'company_description'
    ];

    public function index()
    {
        $company = \Auth::getUser()->company;

        $vacancies = \Auth::getUser()->company->vacancies()
            ->with(['city', 'type', 'hours'])
            ->get(['company_id', 'title', 'city_id', 'type_id', 'excerpt', 'company_title', 'status'])
            ->map(function (Vacancy $vacancy) use ($company) {
                $vacancy->setRelation('company', $company);
            });

        return $vacancies;
    }

    public function show(Vacancy $vacancy)
    {
        $vacancy->load('company');
        return $vacancy;
    }

    public function store(VacancyRequest $request)
    {
        $company = \Auth::getUser()->company;

        /* @var $vacancy Vacancy */
        $vacancy = $company->vacancies()->create($request->only($this->fillable));
        $request->syncHours($vacancy);
        $request->syncBenefits($vacancy);
        //todo incentives and skills
        return $vacancy;
    }

    public function update(VacancyRequest $request, Vacancy $vacancy)
    {
        $vacancy->update($request->only($this->fillable));
        $request->syncHours($vacancy);
        $request->syncBenefits($vacancy);
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
