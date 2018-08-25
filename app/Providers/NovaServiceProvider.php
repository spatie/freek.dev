<?php

namespace App\Providers;

use Freekmurze\GenerateNewsletter\GenerateNewsletterTool;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Spatie\BackupTool\BackupTool;
use Spatie\TailTool\TailTool;
use Tightenco\NovaGoogleAnalytics\PageViewsMetric;

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
        Gate::define('viewNova', function ($user) {
            return auth()->check();
        });
    }

    protected function cards()
    {
        return [
           new PageViewsMetric(),
        ];
    }

    public function tools()
    {
        return [
            new GenerateNewsletterTool(),
            new BackupTool(),
            new TailTool(),
        ];
    }
}
