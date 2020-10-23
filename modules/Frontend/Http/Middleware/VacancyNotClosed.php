<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyNotClosed
{
    public function handle(Request $request, \Closure $next)
    {
        /* @var $vacancy Vacancy */
        $vacancy = $request->vacancy;
        if ($vacancy->status === Vacancy::CLOSED || $vacancy->deleted_at) abort(403);
        return $next($request);
    }
}
