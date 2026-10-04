<?php

namespace App\Providers;

use App\Jobs\Middleware\ThrottleScreenshots;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Spatie\OgImage\Facades\OgImage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->useTheAttachedBuckets();
    }

    public function boot(): void
    {
        Carbon::setToStringFormat('jS F Y');

        Model::unguard();

        OgImage::fallbackUsing(fn () => view('og-images.default'));

        $this->registerScreenshotRateLimiter();

        $this->rememberAdminsInTheirBrowser();
    }

    /*
     * On Laravel Cloud the assets and backups buckets are attached to the environment as the
     * `object-storage` and `backups` disks, which replaces their configuration. The asset disks
     * store their files in a directory of the assets bucket, so they take over its connection.
     */
    protected function useTheAttachedBuckets(): void
    {
        config()->set('filesystems.disks.backups.throw', true);

        if (! config('filesystems.assets_on_object_storage')) {
            return;
        }

        $assetsBucketConnection = Arr::only(
            config('filesystems.disks.object-storage'),
            ['key', 'secret', 'region', 'bucket', 'endpoint', 'credentials'],
        );

        foreach (config('filesystems.asset_url_segments') as $diskName) {
            config()->set("filesystems.disks.{$diskName}", [
                ...config("filesystems.disks.{$diskName}"),
                ...$assetsBucketConnection,
            ]);
        }
    }

    /*
     * The edge serves the same cached page to everyone, so the browser shows
     * admin-only bits, like the edit link on posts, based on this cookie.
     */
    protected function rememberAdminsInTheirBrowser(): void
    {
        Event::listen(function (Login $event) {
            if (! $event->user->admin) {
                return;
            }

            Cookie::queue(Cookie::forever('admin', '1', httpOnly: false));
        });

        Event::listen(function (Logout $event) {
            Cookie::queue(Cookie::forget('admin'));
        });
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
