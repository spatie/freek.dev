<?php

namespace App\Console;

use App\Console\Commands\ImportWp;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ImportWp::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('responsecache:flush')->daily()->at('00:00');
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        //require base_path('routes/console.php');
    }
}
