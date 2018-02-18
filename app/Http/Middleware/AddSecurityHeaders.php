<?php

namespace App\Http\Middleware;

use Closure;

class AddSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Referrer-Policy', 'strict-origin');
        $response->headers->set('Strict-Transport-Security', 'strict-transport-security: max-age=31536000; includeSubDomains');

        return $response;
    }
}
