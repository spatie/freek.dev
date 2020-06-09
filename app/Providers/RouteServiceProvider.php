<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\DoNotCacheResponse;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->registerRouteModelBindings();
    }

    public function map()
    {
        Route::mailcoach('mailcoach');
        Route::mailgunFeedback('mailgun-feedback');

        $this
            ->mapAuthRoutes()
            ->mapFrontRoutes();
    }

    protected function mapAuthRoutes()
    {
        Route::middleware('web')->group(base_path('routes/auth.php'));

        return $this;
    }

    protected function mapFrontRoutes()
    {
        Route::get('a-test-page', function () {
            sleep(5);

            return 'ok';
        })->middleware(DoNotCacheResponse::class);

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

            if (auth()->check()) {
                return $post;
            }

            if (! $post->published) {
                abort(404);
            }

            return $post;
        });
    }
}
