<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class SharedData
{
    public function handle(Request $request, Closure $next)
    {
        share([
            'user' => \Auth::getUser()
        ]);

        return $next($request);
    }
}
