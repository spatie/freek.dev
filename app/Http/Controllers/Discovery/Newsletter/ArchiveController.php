<?php

namespace App\Http\Controllers\Discovery\Newsletter;

use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;
use Spatie\RouteDiscovery\Attributes\Route;

class ArchiveController
{
    #[Route(name: 'newsletter.show')]
    public function index(Campaign $campaign)
    {
        if (! $campaign->isSent()) {
            abort(404);
        }

        return view('front.newsletter.newsletter', [
            'campaign' => $campaign,
            'webview' => view('mailcoach::campaign.webview', compact('campaign'))->render(),
        ]);
    }
}
