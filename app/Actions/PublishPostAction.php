<?php

namespace App\Actions;

use App\Jobs\CreateOgImageJob;
use App\Jobs\TweetPostJob;
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

        Bus::chain([
            new CreateOgImageJob($post),
            fn () => ResponseCache::clear(),
            new TweetPostJob($post),
        ])->dispatch();
    }
}
