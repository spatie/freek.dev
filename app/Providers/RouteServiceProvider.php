<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        $this->registerRouteModelBindings();
    }

    public function map()
    {
        $this
            ->mapAuthRoutes()
            ->mapRedirects()
            ->mapPackageRoutes()
            ->mapFrontRoutes();
    }

    protected function mapAuthRoutes()
    {
        Route::middleware('web')->group(base_path('routes/auth.php'));

        return $this;
    }

    protected function mapFrontRoutes()
    {
        Route::middleware(['web', 'cacheResponse'])->group(base_path('routes/web.php'));

        return $this;
    }

    public function registerRouteModelBindings()
    {

    }

    protected function mapPackageRoutes(): self
    {
        Route::middleware(['web', 'cacheResponse'])->group(function () {
            Route::feeds('feed');
        });

        return $this;
    }

    protected function mapRedirects(): self
    {
        Route::middleware(['web', 'cacheResponse'])->group(base_path('routes/redirects.php'));

        return $this;
    }
}
