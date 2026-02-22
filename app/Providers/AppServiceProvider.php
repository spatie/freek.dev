<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\OgImage\Facades\OgImage;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('viewHorizon', function (User $user) {
            return $user->admin;
        });

        Carbon::setToStringFormat('jS F Y');

        Model::unguard();

        OgImage::configureScreenshot(function ($screenshot) {
            $screenshot->deviceScaleFactor(2);
        });

        OgImage::fallbackUsing(function (Request $request) {
            return view('og-image.fallback', [
                'title' => config('app.name'),
            ]);
        });
    }
}
