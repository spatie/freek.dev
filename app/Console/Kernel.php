<?php

namespace App\Console;

use App\Console\Commands\PublishScheduledPostsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('responsecache:clear')->daily()->at('00:00');
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')
            ->daily()
            ->pingOnSuccess(config('services.oh_dear.backup_run_ping_endpoint'));

        $schedule->command(PublishScheduledPostsCommand::class)
            ->everyMinute()
            ->pingOnSuccess(config('services.oh_dear.publish_scheduled_posts_ping_endpoint'));

        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:send-email-list-summary-mail ')->mondays()->at('9:00');
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
