<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->registerRouteModelBindings();

        Route::mailcoach('mailcoach');
    }

    public function map()
    {
        $this->mapFrontRoutes();
    }

    protected function mapFrontRoutes()
    {
        Route::middleware(['web', 'cacheResponse'])
            ->group(base_path('routes/web.php'));
    }

    public function registerRouteModelBindings()
    {
        Route::bind('postSlug', function ($slug) {
            $post = Post::findByIdSlug($slug);

            if (! $post) {
                abort(404);
            }

            if (auth()->check()) {
                return $post;
            }

            if (!$post->published) {
                abort(404);
            }

            return $post;
        });
    }
}
