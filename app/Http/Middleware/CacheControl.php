<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControl
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        if ($this->shouldAddCacheHeader($request, $response)) {
            $response->headers->add(['Cache-Control' => 'max-age=600, public']);
        }

        return $response;
    }

    public function shouldAddCacheHeader($request, Response $response): bool
    {
        if (! app()->environment('production')) {
            return false;
        }

        if (auth()->check()) {
            return false;
        }

        if ($request->method() !== 'GET') {
            return false;
        }

        if (! $response->isSuccessful()) {
            return false;
        }

        return true;
    }
}
