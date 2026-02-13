<?php

use App\Jobs\ComputeRelatedPostsJob;
use App\Models\Post;
use App\Services\EmbeddingService;

it('computes and saves related post ids', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'embedding' => array_fill(0, 10, 0.5),
        'related_post_ids' => null,
    ]);

    $relatedIds = [10, 20, 30];

    $embeddingService = Mockery::mock(EmbeddingService::class);
    $embeddingService->shouldReceive('computeRelatedPostIds')
        ->once()
        ->with(Mockery::on(fn ($arg) => $arg->id === $post->id))
        ->andReturn($relatedIds);

    $job = new ComputeRelatedPostsJob($post);
    $job->handle($embeddingService);

    $post->refresh();

    expect($post->related_post_ids)->toBe($relatedIds);
});
