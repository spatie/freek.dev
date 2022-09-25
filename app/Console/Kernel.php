<?php

namespace App\Console;

use App\Console\Commands\PublishScheduledPostsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\Health\Commands\RunHealthChecksCommand;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(RunHealthChecksCommand::class)->everyMinute();
        $schedule->command(PublishScheduledPostsCommand::class)->everyMinute();
        $schedule->command('schedule-monitor:clean')->daily();
        $schedule->command('responsecache:clear')->daily();
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->dailyAt('3:00');
        $schedule->command('site-search:crawl')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
