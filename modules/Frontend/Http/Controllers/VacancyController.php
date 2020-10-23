<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Vacancy;

class VacancyController extends Controller
{
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
}
