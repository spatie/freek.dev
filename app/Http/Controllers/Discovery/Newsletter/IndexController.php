<?php

namespace App\Http\Controllers\Discovery\Newsletter;

use Spatie\RouteDiscovery\Attributes\Route;
use function view;

#[Route(middleware: 'doNotCacheResponse')]
class IndexController
{
    public function __invoke()
    {
        return view('front.newsletter.index');
    }
}
