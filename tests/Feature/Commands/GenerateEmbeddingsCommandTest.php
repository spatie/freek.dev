<?php

use App\Jobs\GeneratePostEmbeddingJob;
use App\Models\Post;
use Illuminate\Support\Facades\Bus;

it('dispatches embedding jobs for published posts without embeddings', function () {
    $postWithoutEmbedding = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'embedding' => null,
    ]);

    $postWithEmbedding = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(2),
        'embedding' => [0.1, 0.2, 0.3],
    ]);

    $unpublishedPost = Post::factory()->create([
        'published' => false,
        'embedding' => null,
    ]);

    $this->artisan('app:generate-embeddings')
        ->expectsOutputToContain('Dispatched embedding jobs for 1 posts')
        ->assertExitCode(0);

    Bus::assertDispatched(GeneratePostEmbeddingJob::class, function ($job) use ($postWithoutEmbedding) {
        return $job->post->id === $postWithoutEmbedding->id;
    });

    Bus::assertNotDispatched(GeneratePostEmbeddingJob::class, function ($job) use ($postWithEmbedding) {
        return $job->post->id === $postWithEmbedding->id;
    });
});

it('dispatches embedding jobs for all published posts when force flag is used', function () {
    $postWithEmbedding = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'embedding' => [0.1, 0.2, 0.3],
    ]);

    $postWithoutEmbedding = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(2),
        'embedding' => null,
    ]);

    $this->artisan('app:generate-embeddings --force')
        ->expectsOutputToContain('Dispatched embedding jobs for 2 posts')
        ->assertExitCode(0);

    Bus::assertDispatched(GeneratePostEmbeddingJob::class, 2);
});
