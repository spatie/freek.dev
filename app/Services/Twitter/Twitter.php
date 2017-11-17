<?php

namespace App\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;
use Log;

class Twitter
{
    /** @var \Abraham\TwitterOAuth\TwitterOAuth  */
    protected $twitter;

    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    public function tweet(string $status)
    {
        if (! app()->environment('production')) {
            Log::info("Tweeting {$status}");

            return;
        }

        return $this->twitter->post('statuses/update', compact('status'));
    }
}
