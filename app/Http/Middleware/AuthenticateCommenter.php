<?php

namespace App\Http\Middleware;

use App\Models\Commenter;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateCommenter
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $commenter = Commenter::where('token', hash('sha256', $token))->first();

        if (! $commenter) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->attributes->set('commenter', $commenter);

        return $next($request);
    }
}
