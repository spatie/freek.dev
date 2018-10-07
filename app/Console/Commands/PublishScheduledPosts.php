<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\ResponseCache\Facades\ResponseCache;

class PublishScheduledPosts extends Command
{
    protected $signature = 'blog:publish-scheduled-posts';

    protected $description = 'Publish scheduled posts';

    public function handle()
    {
        Post::scheduled()->get()->each(function(Post $post) {
           if (optional($post->publish_date)->isFuture()) {
              return;
           }

            $post->publish();

            $this->info("Post `{$post->title}` published!");

            ResponseCache::flush();
        });
    }
}
