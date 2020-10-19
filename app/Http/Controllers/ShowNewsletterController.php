<?php

namespace App\Http\Controllers;

use Spatie\Mailcoach\Models\Campaign;

class ShowNewsletterController
{
    public function __invoke(string $campaignUuid)
    {
        if (! $campaign = Campaign::findByUuid($campaignUuid)) {
            abort(404);
        }

        if ($campaign->isDraft()) {
            abort(404);
        }

        return view('front.newsletter.newsletter', compact('campaign'));
    }
}
