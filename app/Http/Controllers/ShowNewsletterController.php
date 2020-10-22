<?php

namespace App\Http\Controllers;

use Spatie\Mailcoach\Models\Campaign;

class ShowNewsletterController
{
    public function __invoke(Campaign $campaign)
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
