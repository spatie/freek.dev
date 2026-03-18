<?php

namespace App\Console\Commands;

use App\Jobs\ComputeRelatedPostsJob;
use App\Models\Post;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:compute-related-posts')]
class ComputeRelatedPostsCommand extends Command
{
    public function handle(): void
    {
        $count = 0;

        Post::query()
            ->published()
            ->whereNotNull('embedding')
            ->each(function (Post $post) use (&$count) {
                dispatch(new ComputeRelatedPostsJob($post));
                $count++;
            });

        $this->info("Dispatched related posts jobs for {$count} posts.");
    }
}
