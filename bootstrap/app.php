<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\FlashServiceProvider::class,
        \App\Providers\HorizonServiceProvider::class,
        \App\Providers\Filament\AdminPanelProvider::class,
        \App\Providers\Filament\AdminPanelProvider::class,
        \App\Providers\RouteServiceProvider::class,
        \App\Providers\VoltServiceProvider::class,
        \App\Providers\FolioServiceProvider::class,
        \App\Providers\NavigationServiceProvider::class,
        \App\Services\Twitter\TwitterServiceProvider::class,
        \App\Providers\ViewServiceProvider::class,
        \App\Providers\BladeComponentServiceProvider::class,
        \App\Providers\HealthServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo('/');

        $middleware->append(\Spatie\MissingPageRedirector\RedirectsMissingPages::class);

        $middleware->web(\App\Http\Middleware\CacheControl::class);

        $middleware->api('throttle:60,1');

        $middleware->replace(\Illuminate\Foundation\Http\Middleware\TrimStrings::class, \App\Http\Middleware\TrimStrings::class);

        $middleware->replaceInGroup('web', \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class, \App\Http\Middleware\VerifyCsrfToken::class);

        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'cacheResponse' => \Spatie\ResponseCache\Middlewares\CacheResponse::class,
            'doNotCacheResponse' => \Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
