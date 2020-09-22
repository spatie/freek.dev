<?php

namespace App\Console;

use App\Console\Commands\PublishScheduledPostsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(PublishScheduledPostsCommand::class)->everyMinute();
        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
        $schedule->command('schedule-monitor:clean')->daily();
        $schedule->command('responsecache:clear')->daily();
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->dailyAt('3:00');
        $schedule->command('mailcoach:send-email-list-summary-mail ')->mondays()->at('9:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
