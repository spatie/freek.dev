<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\FlareErrorOccurrenceCountCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\MeiliSearchCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

class HealthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Health::checks([
            CpuLoadCheck::new()->failWhenLoadIsHigherInTheLast15Minutes(4.0),
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            MeiliSearchCheck::new(),
            EnvironmentCheck::new(),
            DatabaseCheck::new(),
            HorizonCheck::new(),
            UsedDiskSpaceCheck::new()
                ->warnWhenUsedSpaceIsAbovePercentage(90)
                ->failWhenUsedSpaceIsAbovePercentage(95),
            FlareErrorOccurrenceCountCheck::new()
                ->projectId(config('services.flare.project_id'))
                ->apiToken(config('services.flare.api_token'))
                ->failWhenMoreErrorsReceivedThan(300),
            SecurityAdvisoriesCheck::new(),
        ]);
    }
}
