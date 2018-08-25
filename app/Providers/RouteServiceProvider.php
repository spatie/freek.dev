<?php

namespace App\Providers;

use App\Models\Post;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Tags\Tag;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        parent::boot();

        $this->registerRouteModelBindings();
    }

    public function map()
    {
        $this->mapFrontRoutes();
    }

    protected function mapFrontRoutes()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    public function registerRouteModelBindings()
    {
        Route::bind('postSlug', function ($slug) {
            $post = Post::where('slug', $slug)->first() ?? abort(404);

            if (auth()->check()) {
                return $post;
            }

            if (!$post->published) {
                abort(404);
            }

            return $post;
        });

        Route::bind('tagSlug', function ($slug) {
            return Tag::where('slug->en', $slug)->first() ?? abort(404);
        });
    }
}
