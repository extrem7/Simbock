<?php

namespace Modules\Frontend\Http\Middleware;

use App\Models\SearchQuery;
use Auth;
use Closure;
use Illuminate\Http\Request;

class Searched
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response): void
    {
        if ($request->exists('page')) return;

        $route = $request->route();
        $attributes = [
            'query' => $route->parameter('query'),
            'location' => $route->parameter('location'),
        ];
        if ($attributes['query']) {
            if (($user = Auth::user()) && $client = $user->getClient()) {
                $client->searchQueries()->create($attributes);
            } else {
                SearchQuery::create($attributes);
            }
        }
    }
}
