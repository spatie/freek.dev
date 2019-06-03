<?php

namespace App\Providers;

use Freekmurze\GenerateNewsletter\GenerateNewsletterTool;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use OhDear\OhDearTool\OhDearTool;
use Spatie\BackupTool\BackupTool;
use Spatie\TailTool\TailTool;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    protected function gate()
    {
        Gate::define('viewNova', function () {
            return auth()->check();
        });
    }

    protected function cards()
    {
        return [

        ];
    }

    public function tools()
    {
        return [
            new GenerateNewsletterTool(),
            new BackupTool(),
            new TailTool(),
            new OhDearTool(),
        ];
    }
}
