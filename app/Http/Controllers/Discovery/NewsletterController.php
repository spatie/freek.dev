<?php

namespace App\Http\Controllers\Discovery;

use Illuminate\View\View;
use Spatie\RouteDiscovery\Attributes\Route;

#[Route(middleware: ['doNotCacheResponse'])]
class NewsletterController
{
    public function __invoke(): View
    {
        return view('front.newsletter.index');
    }
}
