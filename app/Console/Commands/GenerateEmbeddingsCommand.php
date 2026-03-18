<?php

namespace App\Console\Commands;

use App\Jobs\GeneratePostEmbeddingJob;
use App\Models\Post;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:generate-embeddings {--force : Regenerate embeddings for all posts}')]
class GenerateEmbeddingsCommand extends Command
{
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
