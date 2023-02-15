<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;

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
