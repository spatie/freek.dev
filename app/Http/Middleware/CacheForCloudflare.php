<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheForCloudflare
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->shouldCache($request, $response)) {
            $response->headers->remove('Set-Cookie');
            $response->headers->set('Cache-Control', 'max-age=600, public');
        }

        return $response;
    }

    protected function shouldCache(Request $request, Response $response): bool
    {
        if (! $this->isEnabled()) {
            return false;
        }

        if (! $request->isMethodCacheable() || ! $response->isSuccessful()) {
            return false;
        }

        // Don't cache for logged-in users
        if ($request->hasCookie(config('session.cookie'))) {
            return false;
        }

        // Don't cache auth pages (need CSRF tokens)
        return ! $request->routeIs('login', 'register', 'password.*');
    }

    protected function isEnabled(): bool
    {
        if (app()->runningUnitTests()) {
            return config('cache.cloudflare_enabled', false);
        }

        return app()->environment('production');
    }
}
