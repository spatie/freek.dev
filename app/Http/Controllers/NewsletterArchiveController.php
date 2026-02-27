<?php

namespace App\Http\Controllers;

use App\Models\NewsletterCampaign;
use Illuminate\View\View;

class NewsletterArchiveController
{
    public function newsletter(): View
    {
        $latestCampaign = NewsletterCampaign::query()
            ->orderByDesc('sent_at')
            ->first();

        return view('front.pages.newsletter.index', [
            'latestCampaign' => $latestCampaign,
        ]);
    }

    public function index(): View
    {
        $campaigns = NewsletterCampaign::query()
            ->orderByDesc('sent_at')
            ->get();

        $campaignsByYear = $campaigns->groupBy(fn (NewsletterCampaign $campaign) => $campaign->sent_at->format('Y'));

        return view('front.pages.newsletter.archive', [
            'campaignsByYear' => $campaignsByYear,
        ]);
    }

    public function show(NewsletterCampaign $newsletterCampaign): View
    {
        return view('front.pages.newsletter.archive-show', [
            'newsletterCampaign' => $newsletterCampaign,
        ]);
    }
}
