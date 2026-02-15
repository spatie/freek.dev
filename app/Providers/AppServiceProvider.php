<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('viewHorizon', function (User $user) {
            return $user->admin;
        });

        Carbon::setToStringFormat('jS F Y');

        Model::unguard();

        RateLimiter::for('comment-creation', function ($request) {
            $commenter = $request->attributes->get('commenter');

            return Limit::perMinute(5)->by($commenter?->id ?? $request->ip());
        });
    }
}
