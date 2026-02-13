<?php

use App\Jobs\GeneratePostEmbeddingJob;
use App\Models\Post;
use App\Services\EmbeddingService;

it('generates and saves an embedding for a post', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'embedding' => null,
    ]);

    $fakeEmbedding = array_fill(0, 10, 0.5);

    $embeddingService = Mockery::mock(EmbeddingService::class);
    $embeddingService->shouldReceive('generateEmbedding')
        ->once()
        ->with(Mockery::on(fn ($arg) => $arg->id === $post->id))
        ->andReturn($fakeEmbedding);

    $job = new GeneratePostEmbeddingJob($post);
    $job->handle($embeddingService);

    $post->refresh();

    expect($post->embedding)->toBe($fakeEmbedding);
});
