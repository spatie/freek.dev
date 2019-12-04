<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
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

        Gate::define('viewMailcoach', function (User $user) {
            return $user->email === 'freek@spatie.be';
        });

        Carbon::setToStringFormat('jS F Y');

        Model::unguard();
    }
}
