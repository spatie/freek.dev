<?php

namespace App\Http\Middleware;

use Closure;

class RedirectContest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->get('utm_campaign') === 'referral') {
            return redirect()->to('/mailcoach-contest');
        }

        return $next($request);
    }
}
