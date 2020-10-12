<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Debugbar;
use Illuminate\Http\Request;

class DebugBarMiddleware
{
    public function handle(Request $request, Closure $next)
    {
      //  Debugbar::disable();

        if (Auth::check() && in_array(Auth::getUser()->email, config('simbok.debugbar_emails'))) {
            Debugbar::enable();
        }

        return $next($request);
    }
}
