<?php

namespace Modules\Frontend\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServerPush
{
    public function handle(Request $request, \Closure $next)
    {
        /* @var $response Response */
        $response = $next($request);
        if ($request->isMethod('GET')) {
            $response->header('Link', '<' . mix('dist/css/app.css') . '>;rel=preload;as=style', false);
        }
        return $response;
    }
}
