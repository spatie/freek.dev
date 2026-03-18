<?php

namespace App\Console\Commands;

use App\Actions\PublishPostAction;
use App\Models\Post;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('blog:publish-scheduled-posts')]
#[Description('Publish scheduled posts')]
class PublishScheduledPostsCommand extends Command
{
    public function handle(PublishPostAction $publishPostAction): void
    {
        Post::query()->scheduled()->get()
            ->reject(fn (Post $post) => $post->publish_date->isFuture())
            ->each(fn (Post $post) => $publishPostAction->execute($post));
    }
}
