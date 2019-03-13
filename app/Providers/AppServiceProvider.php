<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gate::define('viewHorizon', function ($user) {
            return auth()->check();
        });

        Carbon::setToStringFormat('jS F Y');
    }
}
