<?php

namespace App\Actions;

use App\Jobs\CreateOgImageJob;
use App\Jobs\PostOnBlueskyJob;
use App\Jobs\PurgeCloudflareCacheJob;
use App\Jobs\TootPostJob;
use App\Jobs\TweetPostJob;
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

        ResponseCache::clear();

        dispatch(new PurgeCloudflareCacheJob);
        dispatch(new CreateOgImageJob($post));
        dispatch(new TweetPostJob($post))->delay(now()->addSeconds(20));
        dispatch(new TootPostJob($post))->delay(now()->addSeconds(20));
        dispatch(new PostOnBlueskyJob($post))->delay(now()->addSeconds(20));
    }
}
