<?php

namespace App\Http\Middleware;

use Closure;

class RedirectContest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        info(print_r($request->segments(), true));
        if ($request->get('utm_campaign') === 'referral') {
            if ($request->segment(0) !== 'mailcoach-contest') {
                info($request->segment(0));
                return redirect()->to('/mailcoach-contest?referral=QWkWqO9M&utm_campaign=referral');
            }
        }

        return $next($request);
    }
}
