<?php

namespace Modules\Frontend\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class SharedData
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->expectsJson() && $request->isMethod('GET') && $user = Auth::user()) {
            $user->load(['company', 'volunteer'])->append(['is_volunteer']);
            if ($user->company) {
                $user->company->append(['logo', 'employment', 'location', 'is_subscribed']);
            }
            $userData = $user->toArray();

            if ($client = $user->getClient()) {
                $userData['client'] = $client;

                $unviewedMessages = $client->getUnviewedMessages();
            }

            share([
                'user' => $userData,
                'unviewedMessages' => $unviewedMessages ?? 0,
                'social' => config('frontend.social')
            ]);
        }
        return $next($request);
    }
}
