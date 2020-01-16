<?php

namespace App\Providers;

use App\Nova\Ad;
use App\Nova\Link;
use App\Nova\Post;
use App\Nova\Tag;
use App\Nova\Talk;
use App\Nova\User;
use App\Nova\Video;
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

    protected function resources()
    {
        Nova::resources([
            Post::class,
            Link::class,
            Talk::class,
            Video::class,
            Ad::class,
            Tag::class,
            User::class,
        ]);
    }
}
