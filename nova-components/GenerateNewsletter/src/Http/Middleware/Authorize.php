<?php

namespace Freekmurze\GenerateNewsletter\Http\Middleware;

use Freekmurze\GenerateNewsletter\GenerateNewsletterTool;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(GenerateNewsletterTool::class)->authorize($request) ? $next($request) : abort(403);
    }
}
