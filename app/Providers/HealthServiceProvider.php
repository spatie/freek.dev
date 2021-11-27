<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;


class HealthServiceProvider extends ServiceProvider
{
    public function register()
    {
        Health::checks([
            new DebugModeCheck(),
            new EnvironmentCheck(),
            new DatabaseCheck(),
            new HorizonCheck(),
            new UsedDiskSpaceCheck(),
            new ScheduleCheck(),
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
