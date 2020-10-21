<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Company
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->type !== User::COMPANY) abort(403, 'Only for company');
        return $next($request);
    }
}
