<?php

namespace App\Http\Controllers\Discovery\Newsletter;

use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;
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
