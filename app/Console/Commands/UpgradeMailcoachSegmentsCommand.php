<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;

class UpgradeMailCoachSegmentsCommand extends Command
{
    protected $signature = 'upgrade-mailcoach-segments';

    public function handle()
    {
        Campaign::each(function (Campaign $campaign) {
            if ($campaign->segment_class === 'Spatie\Mailcoach\Support\Segments\SubscribersWithTagsSegment') {
                $campaign->update([
                    'segment_class' => 'Spatie\Mailcoach\Domain\Audience\Support\Segments\SubscribersWithTagsSegment',
                ]);
            }

            if ($campaign->segment_class === 'Spatie\Mailcoach\Support\Segments\EverySubscriberSegment') {
                $campaign->update([
                    'segment_class' => 'Spatie\Mailcoach\Domain\Audience\Support\Segments\EverySubscriberSegment',
                ]);
            }
        });

        $this->info('All done!');
    }
}
