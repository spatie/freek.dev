<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
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
        Route::bind('postSlug', function ($slug) {
            $post = Post::findByIdSlug($slug);

            if (! $post) {
                abort(404);
            }

            if (auth()->user()?->email === 'freek@spatie.be') {
                return $post;
            }

            if ($post->preview_secret === request()->get('preview_secret')) {
                return $post;
            }

            if (! $post->published) {
                abort(404);
            }

            return $post;
        });
    }

    protected function mapPackageRoutes(): self
    {
        Route::middleware(['web', 'cacheResponse'])->group(function () {
            Route::feeds('feed');
            Route::webhooks('webhook-webmentions', 'webmentions');
        });

        return $this;
    }

    protected function mapRedirects(): self
    {
        Route::middleware(['web', 'cacheResponse'])->group(base_path('routes/redirects.php'));

        return $this;
    }
}
