<?php

namespace Modules\App\Http\Controllers\Company;

use App\Models\Company;
use Illuminate\Routing\Controller;

class CompanyController extends Controller
{
    public function show(Company $company)
    {
        return $company;
    }

    public function update()
    {
        $user = \Auth::getUser();
        $user->update($request->only('name'));
        $user->company->update($request->except('name'));
    }
}
