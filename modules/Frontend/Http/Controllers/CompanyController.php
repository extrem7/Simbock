<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Company;
use App\Models\Vacancy;

class CompanyController extends Controller
{
    public function show(Company $company)
    {
        $this->seo()->setTitle("$company->name | Companies");

        $company->load('logoMedia', 'city', 'size', 'vacancies');
        $company->append('logo', 'employment', 'location');
        $company->vacancies->transform(fn(Vacancy $v) => $v->append(['employment', 'date', 'location']));

        share(compact('company'));

        return view('frontend::companies.show');
    }

    public function self()
    {
        return $this->show(\Auth::getUser()->company);
    }
}
