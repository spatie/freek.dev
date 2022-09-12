<?php

namespace App\Console\Commands;

use App\Services\Mailcoach;
use App\Services\NewsletterGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GenerateNewsletterCommand extends Command
{
    protected $signature = 'newsletter:generate';

    public function handle()
    {
        $campaigns = Mailcoach::get('campaigns')->json()['data'];

        $latestCampaignName = $campaigns[0]['name'];
        $latestCampaignCreatedAt = Carbon::parse($campaigns[0]['created_at']);
        $startDate = $latestCampaignCreatedAt->addDay()->startOfDay();
        $endDate = now();

        $latestEditionNumber = (int) Str::after($latestCampaignName, '#');
        $newEditionNumber = $latestEditionNumber + 1;

        $markdown = (new NewsletterGenerator(
            $startDate,
            now(),
            $newEditionNumber
        ))->getMarkdown();

        $title = "freek.dev newsletter #{$newEditionNumber}";

        $response = Mailcoach::post('campaigns', [
            'name' => $title,
            'fields' => [
                'title' => $title,
                'content' => $markdown,
            ],
            'from_email' => 'freek@spatie.be',
            'from_name' => 'Freek Van der Herten',
            'subject' => "freek.dev newsletter #{$newEditionNumber}",
            'email_list_uuid' => '585c113f-8479-42cb-a0d4-5f472f82130e',
            'template_uuid' => '86232043-4924-40a1-a0c6-6c9568c4e540',
        ]);

        if ($response->failed()) {
            $this->error('Failed to create campaign');
            $this->error($response->body());

            return self::FAILURE;
        }

        $this->info("freek.dev newsletter #{$newEditionNumber} has been created with posts from {$startDate->format('Y-m-d')} until {$endDate->format('Y-m-d')}!");

        return self::SUCCESS;
    }
}
