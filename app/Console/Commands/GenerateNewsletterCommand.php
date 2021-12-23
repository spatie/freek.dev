<?php

namespace App\Console\Commands;

use App\Services\NewsletterGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Mailcoach\Domain\Audience\Support\Segments\EverySubscriberSegment;
use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;

class GenerateNewsletterCommand extends Command
{
    protected $signature = 'newsletter:generate';

    public function handle()
    {
        /** @var Campaign $latestNewsletter */
        $latestNewsletter = Campaign::latest()->first();
        $latestEditionNumber = (int)Str::after($latestNewsletter->name, '#');
        $newEditionNumber = $latestEditionNumber + 1;
        $startDate =  $latestNewsletter->created_at->addDay()->startOfDay();
        $endDate = now();

        $html = (new NewsletterGenerator(
            $latestNewsletter->sent_at->addDay(),
            now(),
            $newEditionNumber
        ))->getHtml();

        Campaign::create([
            'name' => "freek.dev newsletter #{$newEditionNumber}",
            'uuid' => Str::uuid(),
            'html' > $html,
            'from_email' => 'freek@spatie.be',
            'from_name' => 'Freek Van der Herten',
            'subject' => "freek.dev newsletter #{$newEditionNumber}",
            'email_list_id' => 2,
            'status' => 'draft',
            'track_opens' => 0,
            'track_clicks' => 0,
            'utm_tags' => 1,
            'sent_to_number_of_subscribers' => 0,
            'segment_class' => EverySubscriberSegment::class,
        ]);

        $this->info("freek.dev newsletter #{$newEditionNumber} has been created with posts from {$startDate->format('Y-m-d')} until {$endDate->format('Y-m-d')}!");
    }
}
