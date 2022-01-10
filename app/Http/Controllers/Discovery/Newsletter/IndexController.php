<?php

namespace App\Http\Controllers\Discovery\Newsletter;

use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;
use Spatie\RouteDiscovery\Attributes\Route;
use function view;

#[Route(middleware: 'doNotCacheResponse')]
class IndexController
{
    public function __invoke()
    {
        $pastCampaigns = Campaign::sent()->orderByDesc('sent_at')->limit(100)->get();

        return view('front.newsletter.index', compact('pastCampaigns'));
    }
}
