<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;

class CompleteRegistration
{
    public function handle(Request $request, \Closure $next)
    {
        /* @var $user User */
        $user = $request->user();
        if ($user !== null) {
            if ($user->type === User::COMPANY) {
                $whitelist = [
                    'frontend.company.info.form',
                    'frontend.company.info.update',
                    'frontend.api.cities'
                ];
                if ($user->company === null
                    &&
                    !$request->routeIs(...$whitelist))
                    return redirect(route('frontend.company.info.form'));
            }
        }
        return $next($request);
    }
}
