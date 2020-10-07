<?php

namespace App\Actions;

use App\Jobs\CreatePostOgImageJob;
use App\Jobs\SendPostTweetJob;
use App\Models\Post;
use Illuminate\Support\Facades\Bus;
use Spatie\ResponseCache\Facades\ResponseCache;

class PublishPostAction
{
    public function execute(Post $post)
    {
        $post->published = true;

        if (! $post->publish_date) {
            $post->publish_date = now();
        }

        $post->save();

        $this->sendTweet($post);

        ResponseCache::clear();
    }

    protected function sendTweet(Post $post)
    {
        if (! $post->send_automated_tweet) {
            return;
        }

        if ($post->tweet_sent) {
            return;
        }

        if ($post->isTweet()) {
            return;
        }

        Bus::chain([
            new CreatePostOgImageJob($post),
            new SendPostTweetJob($post),
        ])->dispatch();

        $post->tweet_sent = true;

        $post->save();
    }
}
