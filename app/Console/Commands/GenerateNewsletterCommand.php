<?php

namespace App\Console\Commands;

use App\Services\NewsletterGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\MailcoachSdk\Facades\Mailcoach;

class GenerateNewsletterCommand extends Command
{
    protected $signature = 'newsletter:generate';

    public function handle(): void
    {
        $campaigns = Mailcoach::campaigns();
        $latestCampaign = $campaigns[0];

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

        Mailcoach::createCampaign([
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

        $this->info("freek.dev newsletter #{$newEditionNumber} has been created with posts from {$startDate->format('Y-m-d')} until {$endDate->format('Y-m-d')}!");

        return self::SUCCESS;
    }
}
