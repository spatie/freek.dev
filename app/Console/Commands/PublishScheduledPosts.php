<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\ResponseCache\Facades\ResponseCache;

class PublishScheduledPosts extends Command
{
    protected $signature = 'blog:publish-scheduled-posts';

    protected $description = 'Publish scheduled posts';

    public function handle()
    {
        Post::scheduled()->get()->each(function(Post $post) {
           if (optional($post->published_at)->isPast()) {
               $post->publish();

               ResponseCache::flush();
           }
        });
    }
}
