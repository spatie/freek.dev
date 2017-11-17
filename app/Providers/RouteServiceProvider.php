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

        Route::bind('postSlug', function ($slug) {
            $post =  Post::where('slug', $slug)->first() ?? abort(404);

            if (auth()->check()) {
                return $post;
            }

            if (! $post->published) {
                abort(404);
            }

            return $post;
        });

        Route::bind('tagSlug', function ($slug) {
            return Tag::where('slug->en', $slug)->first() ?? abort(404);
        });
    }

    public function map()
    {
        $this->mapBackRoutes();

        $this->mapFrontRoutes();
    }

    protected function mapBackRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\\Back')
            ->group(function () {
                Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
                Route::post('/login', 'Auth\LoginController@login');
                Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

                Route::prefix('admin')->group(function () {
                    Route::middleware('auth')->group(base_path('routes/back.php'));
                });
            });
    }

    protected function mapFrontRoutes()
    {
        Route::middleware(['web', 'cacheResponse'])
            ->namespace($this->namespace . '\\Front')
            ->group(base_path('routes/front.php'));
    }
}
