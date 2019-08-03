<?php

namespace App\Console;

use App\Console\Commands\ImportNewslettersCommand;
use App\Console\Commands\PublishScheduledPostsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('responsecache:flush')->daily()->at('00:00');
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');
        $schedule->command(PublishScheduledPostsCommand::class)->hourly();
        $schedule->command(ImportNewslettersCommand::class)->dailyAt('15:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
