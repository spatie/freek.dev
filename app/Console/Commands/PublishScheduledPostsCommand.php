<?php

namespace App\Console\Commands;

use App\Actions\PublishPostAction;
use App\Models\Post;
use Illuminate\Console\Command;

class PublishScheduledPostsCommand extends Command
{
    protected $signature = 'blog:publish-scheduled-posts';

    protected $description = 'Publish scheduled posts';

    public function handle(PublishPostAction $publishPostAction): void
    {
        Post::scheduled()->get()
            ->reject(fn (Post $post) => $post->publish_date->isFuture())
            ->each(fn (Post $post) => $publishPostAction->execute($post));
    }
}
