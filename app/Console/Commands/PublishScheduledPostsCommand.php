<?php

namespace App\Console\Commands;

use App\Actions\PublishPostAction;
use App\Models\Post;
use Illuminate\Console\Command;

class PublishScheduledPostsCommand extends Command
{
    protected $signature = 'blog:publish-scheduled-posts';

    protected $description = 'Publish scheduled posts';

    public function handle(PublishPostAction $publishPostAction)
    {
        Post::scheduled()->get()
            ->reject(fn (Post $post) => $post->publish_date->isFuture())
            ->each(fn (Post $post) => $publishPostAction->execute($post));

        $pingEndpoint = config('services.oh_dear.publish_scheduled_posts_ping_endpoint');

        file_get_contents($pingEndpoint);
    }
}
