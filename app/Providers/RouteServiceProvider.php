<?php

namespace App\Providers;

use App\Models\Post;
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
        Route::bind('post', function($slugId) {
            return Post::findByIdSlug($slugId);
        });

        Route::bind('postSlug', function($slugId) {
            return Post::findByIdSlug($slugId);
        });
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
