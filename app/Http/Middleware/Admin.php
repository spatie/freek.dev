<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next, $guard = null)
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
