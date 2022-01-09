<?php

namespace App\Http\Controllers\Discovery;

use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;
use function view;

class NewsletterController
{
    public function __invoke()
    {
        $pastCampaigns = Campaign::sent()->orderByDesc('sent_at')->limit(100)->get();

        return view('front.newsletter.index', compact('pastCampaigns'));
    }
}
