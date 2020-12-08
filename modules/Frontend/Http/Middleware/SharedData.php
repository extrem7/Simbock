<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\User;
use Auth;
use Closure;
use Illuminate\Http\Request;

class SharedData
{
    public function handle(Request $request, Closure $next)
    {
        if ($user = Auth::user()) {
            $user->load(['company', 'volunteer'])->append(['is_volunteer']);
            if ($user->company) {
                $user->company->append(['logo', 'employment', 'location']);
            }
        }

        share([
            'user' => $user
        ]);

        return $next($request);
    }
}
