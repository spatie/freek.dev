<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\CacheControl;
use App\Http\Middleware\VerifyCsrfToken;
use App\Providers\BladeComponentServiceProvider;
use App\Providers\Filament\AdminPanelProvider;
use App\Providers\FlashServiceProvider;
use App\Providers\FolioServiceProvider;
use App\Providers\HealthServiceProvider;
use App\Providers\HorizonServiceProvider;
use App\Providers\NavigationServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Providers\ViewServiceProvider;
use App\Providers\VoltServiceProvider;
use App\Services\Twitter\TwitterServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelFlare\Facades\Flare;
use Spatie\MissingPageRedirector\RedirectsMissingPages;
use Spatie\ResponseCache\Middlewares\CacheResponse;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        FlashServiceProvider::class,
        HorizonServiceProvider::class,
        AdminPanelProvider::class,
        RouteServiceProvider::class,
        VoltServiceProvider::class,
        FolioServiceProvider::class,
        NavigationServiceProvider::class,
        TwitterServiceProvider::class,
        ViewServiceProvider::class,
        BladeComponentServiceProvider::class,
        HealthServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo('/');

        $middleware->append(RedirectsMissingPages::class);

        $middleware->web(CacheControl::class);

        $middleware->api('throttle:60,1');

        $middleware->replace(TrimStrings::class, \App\Http\Middleware\TrimStrings::class);

        $middleware->replaceInGroup('web', ValidateCsrfToken::class, VerifyCsrfToken::class);

        $middleware->alias([
            'admin' => Admin::class,
            'cacheResponse' => CacheResponse::class,
            'doNotCacheResponse' => DoNotCacheResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        Flare::handles($exceptions);

        $exceptions->reportable(function (ValidationException $exception) {
            flash()->error('Please correct the errors in the form');
        });
    })->create();
