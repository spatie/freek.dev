<?php

namespace App\Console\Commands;

use App\Models\NewsletterCampaign;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\MailcoachSdk\Facades\Mailcoach;
use Spatie\ResponseCache\Facades\ResponseCache;

class SyncNewsletterCampaignsCommand extends Command
{
    protected $signature = 'newsletter:sync-campaigns';

    protected $description = 'Sync sent newsletter campaigns from Mailcoach';

    public function handle(): void
    {
        $this->info('Syncing newsletter campaigns from Mailcoach...');

        $existingUuids = NewsletterCampaign::query()->pluck('mailcoach_uuid')->flip();

        $imported = 0;
        $skipped = 0;

        $campaigns = Mailcoach::campaigns();

        while ($campaigns) {
            foreach ($campaigns as $campaign) {
                if (! Str::startsWith($campaign->name, 'freek.dev newsletter')) {
                    continue;
                }

                if ($campaign->status !== 'sent') {
                    continue;
                }

                if ($existingUuids->has($campaign->uuid)) {
                    $skipped++;

                    continue;
                }

                $this->info("Importing `{$campaign->name}`...");

                $fullCampaign = Mailcoach::campaign($campaign->uuid);

                NewsletterCampaign::query()->create([
                    'mailcoach_uuid' => $campaign->uuid,
                    'name' => $campaign->name,
                    'edition_number' => (int) Str::after($campaign->name, '#'),
                    'slug' => Str::slug($campaign->name),
                    'web_view_html' => $fullCampaign->webviewHtml ?? '',
                    'sent_at' => $campaign->sentAt,
                ]);

                $imported++;
            }

            $campaigns = $campaigns->next();
        }

        if ($imported > 0) {
            ResponseCache::clear();
        }

        $this->comment("Done! Imported {$imported} campaigns, skipped {$skipped} already existing.");
    }
}
