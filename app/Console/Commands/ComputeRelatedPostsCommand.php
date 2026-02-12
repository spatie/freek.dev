<?php

namespace App\Console\Commands;

use App\Jobs\ComputeRelatedPostsJob;
use App\Models\Post;
use Illuminate\Console\Command;

class ComputeRelatedPostsCommand extends Command
{
    protected $signature = 'app:compute-related-posts';

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
