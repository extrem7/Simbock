<?php

namespace Modules\App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Vacancy;

class CandidatesController extends Controller
{
    public function show(Vacancy $vacancy)
    {
        $candidates = $vacancy->applies;//todo
        return $candidates;
    }

    public function saved()
    {
        $company = \Auth::user()->company;
        $candidates = $company->savedCandidates;//todo
        return $candidates;
    }

    public function recommended()
    {
        $candidates = [];
        return $candidates;//todo
    }

    public function save()
    {
        //todo
    }
}
