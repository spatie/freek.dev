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

        Bus::chain([
            new CreatePostOgImageJob($post),
            new SendPostTweetJob($post),
            fn () => ResponseCache::clear(),
        ])->dispatch();
    }
}
