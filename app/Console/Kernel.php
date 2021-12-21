<?php

namespace App\Console;

use App\Console\Commands\PublishScheduledPostsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Health\Commands\RunChecksCommand;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;
use Spatie\Health\Models\HealthCheckResultHistoryItem;
use Spatie\ModelCleanup\Commands\CleanUpModelsCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(RunHealthChecksCommand::class)->everyMinute();
        $schedule->command('mailcoach:run-automation-triggers')->everyMinute()->runInBackground();
        $schedule->command('mailcoach:run-automation-actions')->everyMinute()->runInBackground();
        $schedule->command('mailcoach:calculate-automation-mail-statistics')->everyMinute();
        $schedule->command(PublishScheduledPostsCommand::class)->everyMinute();
        $schedule->command('mailcoach:calculate-statistics')->everyMinute();
        $schedule->command('mailcoach:send-scheduled-campaigns')->everyMinute();
        $schedule->command('mailcoach:send-campaign-summary-mail')->hourly();
        $schedule->command('mailcoach:delete-old-unconfirmed-subscribers')->daily();
        $schedule->command('schedule-monitor:clean')->daily();
        $schedule->command('responsecache:clear')->daily();
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->dailyAt('3:00');
        $schedule->command(CleanUpModelsCommand::class)->daily();
        $schedule->command('mailcoach:send-email-list-summary-mail ')->mondays()->at('9:00');
        $schedule->command('site-search:crawl')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
