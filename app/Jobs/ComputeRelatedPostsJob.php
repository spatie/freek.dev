<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\EmbeddingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ComputeRelatedPostsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Post $post
    ) {}

    public function handle(EmbeddingService $embeddingService): void
    {
        $relatedPostIds = $embeddingService->computeRelatedPostIds($this->post);

        Post::withoutEvents(function () use ($relatedPostIds) {
            $this->post->update(['related_post_ids' => $relatedPostIds]);
        });
    }
}
