<?php

namespace Modules\Frontend\Http\Controllers\Volunteer;

use App\Models\Company;
use Illuminate\Support\Collection;
use Modules\Frontend\Http\Controllers\Controller;
use Route2Class;

class CompanyController extends Controller
{
    public function __invoke()
    {
        $this->seo()->setTitle("Recommended companies");

        $companies = Company::query()
            ->with(['logoMedia', 'size', 'city'])
            ->select(['id', 'size_id', 'city_id', 'name', 'title'])
            ->paginate(5);

        /* @var $companies Collection<Company> */
        $companies->transform(function (Company $company) {
            $company->append(['logo', 'employment', 'location']);
            return $company;
        });

        if (request()->expectsJson()) {
            return $companies;
        }

        share(compact('companies'));

        Route2Class::addClass('page-with-search');

        return view('frontend::volunteer.companies');
    }
}
