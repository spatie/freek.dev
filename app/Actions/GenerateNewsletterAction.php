<?php

namespace App\Actions;

use App\Services\NewsletterGenerator;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\MailcoachSdk\Facades\Mailcoach;
use Spatie\MailcoachSdk\Resources\Campaign;

class GenerateNewsletterAction
{
    public function execute(): GenerateNewsletterResult
    {
        $latestCampaign = $this->getLatestFreekDevCampaign();

        $latestCampaignName = $latestCampaign->name;
        $latestEditionNumber = (int) Str::after($latestCampaignName, '#');

        $latestCampaignCreatedAt = Carbon::parse($latestCampaign->createdAt);
        $startDate = $latestCampaignCreatedAt->addDay()->startOfDay();
        $endDate = now();

        $newEditionNumber = $latestEditionNumber + 1;

        $markdown = (new NewsletterGenerator(
            $startDate,
            now(),
            $newEditionNumber
        ))->getMarkdown();

        $title = "freek.dev newsletter #{$newEditionNumber}";

        $campaign = Mailcoach::createCampaign([
            'name' => $title,
            'fields' => [
                'title' => $title,
                'content' => $markdown,
            ],
            'from_email' => 'freek@spatie.be',
            'from_name' => 'Freek Van der Herten',
            'subject' => "freek.dev newsletter #{$newEditionNumber}",
            'email_list_uuid' => config('services.mailcoach.email_list_uuid'),
            'template_uuid' => '86232043-4924-40a1-a0c6-6c9568c4e540',
        ]);

        return new GenerateNewsletterResult(
            campaign: $campaign,
            editionNumber: $newEditionNumber,
            startDate: $startDate,
            endDate: $endDate,
        );
    }

    protected function getLatestFreekDevCampaign(): Campaign
    {
        $campaigns = Mailcoach::campaigns();

        foreach ($campaigns as $campaign) {
            if (Str::startsWith($campaign->name, 'freek.dev newsletter')) {
                return $campaign;
            }
        }

        throw new Exception('Could not find a freek.dev campaign');
    }
}
