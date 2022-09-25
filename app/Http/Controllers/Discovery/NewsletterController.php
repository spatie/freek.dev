<?php

namespace App\Http\Controllers\Discovery;

use Spatie\RouteDiscovery\Attributes\Route;

#[Route(middleware: 'doNotCacheResponse')]
class NewsletterController
{
    public function __invoke()
    {
        return view('front.newsletter.index');
    }
}
