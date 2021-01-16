<?php

namespace Modules\Frontend\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VolunteerViewed
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $company = Auth::user()->company;
        if ($company->canSeeVolunteer()) {
            $company->update(['resume_views' => $company->resume_views + 1]);
        }
    }
}
