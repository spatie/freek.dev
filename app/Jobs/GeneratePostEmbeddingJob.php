<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\EmbeddingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePostEmbeddingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Post $post
    ) {}

    public function handle(EmbeddingService $embeddingService): void
    {
        $embedding = $embeddingService->generateEmbedding($this->post);

        Post::withoutEvents(function () use ($embedding) {
            $this->post->update(['embedding' => $embedding]);
        });
    }
}
