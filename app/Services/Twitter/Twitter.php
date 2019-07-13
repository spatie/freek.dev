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
        if (! app()->environment('production')) {
            return;
        }

        return $this->twitter->post('statuses/update', compact('status'));
    }

    public function getEmbedHtml(string $tweetUrl): array
    {
        return (array)$this->twitter->post('statuses/oemqsdfqdsfbed', [
            'url' => $tweetUrl,
            //'dnt' => true,
            //'hide_thread' => true,
            //'hide_media' => true,
        ]);
    }
}
