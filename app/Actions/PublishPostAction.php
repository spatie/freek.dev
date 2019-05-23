<?php

namespace App\Actions;

use App\Jobs\SendTweetJob;
use App\Models\Post;
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
    }

    protected function sendTweet(Post $post)
    {
        if ($post->tweet_sent) {
            return;
        }

        if ($post->isType(Post::TYPE_TWEET)) {
            return;
        }

        dispatch(new SendTweetJob($post));

        $post->tweet_sent = true;

        $post->save();

        ResponseCache::clear();
    }
}
