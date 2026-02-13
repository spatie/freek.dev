<?php

namespace App\Jobs;

use App\Models\Post;
use App\Services\TaggingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePostTagsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Post $post
    ) {}

    public function handle(TaggingService $taggingService): void
    {
        if ($this->post->tags->isNotEmpty()) {
            return;
        }

        $tags = $taggingService->generateTags($this->post);

        if (empty($tags)) {
            return;
        }

        Post::withoutEvents(function () use ($tags) {
            $this->post->syncTags($tags);
        });
    }
}
