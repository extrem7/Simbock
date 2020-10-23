<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyOwner
{
    public function handle(Request $request, \Closure $next)
    {
        /* @var $vacancy Vacancy */
        $vacancy = $request->vacancy;
        if ($vacancy->company_id !== $request->user()->company->id) abort(403);
        return $next($request);
    }
}
