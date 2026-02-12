<?php

namespace App\Console\Commands;

use App\Jobs\GeneratePostEmbeddingJob;
use App\Models\Post;
use Illuminate\Console\Command;

class GenerateEmbeddingsCommand extends Command
{
    protected $signature = 'app:generate-embeddings {--force : Regenerate embeddings for all posts}';

    public function handle(): void
    {
        $query = Post::query()->published();

        if (! $this->option('force')) {
            $query->whereNull('embedding');
        }

        $count = 0;

        $query->each(function (Post $post) use (&$count) {
            dispatch(new GeneratePostEmbeddingJob($post));
            $count++;
        });

        $this->info("Dispatched embedding jobs for {$count} posts.");
    }
}
