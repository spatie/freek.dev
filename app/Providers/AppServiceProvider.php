<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Horizon::auth(function ($request) {
            if (! app()->environment('production')) {
                return true;
            }

            return auth()->check();
        });

        Carbon::setToStringFormat('jS F Y');
    }
}
