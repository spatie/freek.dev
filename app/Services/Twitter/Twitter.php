<?php

namespace App\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;

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
        return $this->twitter->post('statuses/update', compact('status'));
    }
}
