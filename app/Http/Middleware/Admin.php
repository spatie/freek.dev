<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        if (! $user = Auth::user()) {
            return redirect()->route('login');
        }

        if (! $user->admin) {
            abort(403);
        }

        return $next($request);
    }
}
