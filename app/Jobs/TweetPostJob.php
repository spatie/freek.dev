<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\Twitter\Twitter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TweetPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public object $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle(Twitter $twitter): void
    {
        if (! $this->post->send_automated_tweet) {
            return;
        }

        if ($this->post->tweet_sent) {
            return;
        }

        if ($this->post->isTweet()) {
            return;
        }

        $tweetText = $this->post->toTweet();

        $tweetResponse = $twitter->tweet($tweetText);

        if (! isset($tweetResponse['data']->id)) {
            return;
        }

        $tweetUrl = "https://twitter.com/freekmurze/status/{$tweetResponse['data']->id}";

        $this->post->onAfterTweet($tweetUrl);

        $this->post->update(['tweet_sent' => true]);
    }
}
