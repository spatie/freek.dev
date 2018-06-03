<?php

namespace App\Http\Middleware;

use Closure;

class Turbolinks
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Turbolinks-Location', $request->url(), false);

        return $response;
    }
}
