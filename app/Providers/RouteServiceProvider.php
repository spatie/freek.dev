<?php

namespace App\Providers;

use App\Http\Controllers\ServeObjectStorageAssetController;
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
            ->mapApiRoutes()
            ->mapAuthRoutes()
            ->mapRedirects()
            ->mapPackageRoutes()
            ->mapObjectStorageAssetRoutes()
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
        Route::bind('post', function ($slugId) {
            return Post::findByIdSlug($slugId);
        });

        Route::bind('postSlug', function ($slugId) {
            return Post::findByIdSlug($slugId);
        });
    }

    protected function mapApiRoutes(): self
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

        return $this;
    }

    protected function mapPackageRoutes(): self
    {
        Route::middleware(['web', 'cacheResponse'])->group(function () {
            Route::feeds('feed');
        });

        return $this;
    }

    protected function mapObjectStorageAssetRoutes(): self
    {
        if (! config('filesystems.assets_on_object_storage')) {
            return $this;
        }

        $segments = implode('|', array_keys(config('filesystems.asset_url_segments')));

        Route::get('{segment}/{path}', ServeObjectStorageAssetController::class)
            ->where('segment', $segments)
            ->where('path', '.*')
            ->name('objectStorageAsset');

        return $this;
    }

    protected function mapRedirects(): self
    {
        Route::middleware(['web', 'cacheResponse'])->group(base_path('routes/redirects.php'));

        return $this;
    }
}
