<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Volunteer
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->type !== User::VOLUNTEER) abort(403, 'Only for volunteer');
        return $next($request);
    }
}
