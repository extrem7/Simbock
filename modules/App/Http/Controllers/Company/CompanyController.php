<?php

namespace Modules\App\Http\Controllers\Company;

use App\Models\Company;
use Illuminate\Routing\Controller;
use Modules\App\Http\Requests\Company\CompanyRequest;

class CompanyController extends Controller
{
    public function show(Company $company)
    {
        return $company;
    }

    public function update(CompanyRequest $request)
    {
        $user = \Auth::getUser();
        $user->update($request->only('name'));
        $user->company->update($request->except('name'));
    }
}
