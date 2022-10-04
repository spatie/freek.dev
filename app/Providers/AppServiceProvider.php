<?php

namespace App\Providers;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Comments\Models\Comment;
use Spatie\Comments\Notifications\PendingCommentNotification;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gate::define('viewHorizon', function (User $user) {
            return $user->admin;
        });

        Carbon::setToStringFormat('jS F Y');

        Model::unguard();

        PendingCommentNotification::sendTo(function (Comment $comment) {
            return User::where('email', 'freek@spatie.be')->first();
        });

        Filament::registerTheme(
            app(Vite::class)('resources/css/filament.css'),
        );
    }
}
