<?php

namespace App\Services\Twitter;

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter
{
    protected TwitterOAuth $twitter;

    public function __construct(TwitterOAuth $twitter)
    {
        $this->twitter = $twitter;
    }

    public function tweet(string $text)
    {
        if (! app()->environment('production')) {
            //return;
        }
dump('here');
        return (array) $this->twitter->post('tweets', compact('text'));
    }
}
