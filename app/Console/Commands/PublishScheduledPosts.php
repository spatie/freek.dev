<?php

namespace App\Console\Commands;

use App\Actions\PublishPostAction;
use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\ResponseCache\Facades\ResponseCache;

class PublishScheduledPosts extends Command
{
    protected $signature = 'blog:publish-scheduled-posts';

    protected $description = 'Publish scheduled posts';

    /** @var \App\Actions\PublishPostAction */
    private $publishPostAction;

    public function __construct(PublishPostAction $publishPostAction)
    {
        $this->publishPostAction = $publishPostAction;

        parent::__construct();
    }

    public function handle()
    {
        Post::scheduled()->each(function (Post $post) {
            if (optional($post->publish_date)->isFuture()) {
                return;
            }

            $post->publish();

            $this->info("Post `{$post->title}` published!");

            ResponseCache::flush();
        });
    }
}
