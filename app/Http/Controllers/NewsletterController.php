<?php

namespace App\Http\Controllers;

use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;

class NewsletterController
{
    public function __invoke()
    {
        $pastCampaigns = Campaign::sent()->orderByDesc('sent_at')->limit(100)->get();

        return view('front.newsletter.index', compact('pastCampaigns'));
    }
}
