<?php

namespace App\Providers;

use App\Jobs\Middleware\ThrottleScreenshots;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
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

        OgImage::fallbackUsing(fn () => view('og-images.default'));

        $this->registerScreenshotRateLimiter();
    }

    /*
     * Cloudflare Browser Run allows about one screenshot every 10 seconds per account,
     * and spatie.be uses the same account with the same limit of one every 20 seconds.
     */
    protected function registerScreenshotRateLimiter(): void
    {
        RateLimiter::for(ThrottleScreenshots::$rateLimiter, function () {
            if (config('laravel-screenshot.driver') !== 'cloudflare') {
                return Limit::none();
            }

            return Limit::perSecond(1, 20);
        });
    }
}
