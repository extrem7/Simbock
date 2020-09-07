<?php

namespace Modules\Admin\Http\Middleware;

use Auth;
use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::getUser()->can('access admin panel')) {
            return $next($request);
        }
        abort(404);
    }
}
