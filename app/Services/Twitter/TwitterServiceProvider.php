<?php

namespace App\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Twitter::class, function () {
            $connection = new TwitterOAuth(
                config('services.twitter.consumer_key'),
                config('services.twitter.consumer_secret'),
                config('services.twitter.access_token'),
                config('services.twitter.access_token_secret')
            );

            return new Twitter($connection);
        });
    }
}
