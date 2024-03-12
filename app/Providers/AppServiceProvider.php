<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\Notifications\PendingCommentNotification;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('viewHorizon', function (User $user) {
            return $user->admin;
        });
        Gate::define('viewPulse', function (User $user) {
            if (app()->environment('local')) {
                return true;
            }

            return $user->admin;
        });

        Carbon::setToStringFormat('jS F Y');

        Model::unguard();

        PendingCommentNotification::sendTo(function (Comment $comment) {
            return User::where('email', 'freek@spatie.be')->first();
        });

        $this->bootAuth();
    }

    public function bootAuth(): void
    {
        $this->registerPolicies();

        //
    }
}
