<?php

use App\Jobs\ComputeRelatedPostsJob;
use App\Models\Post;
use Illuminate\Support\Facades\Bus;

it('dispatches related posts jobs for posts with embeddings', function () {
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

    $unpublishedPost = Post::factory()->create([
        'published' => false,
        'embedding' => [0.1, 0.2, 0.3],
    ]);

    $this->artisan('app:compute-related-posts')
        ->expectsOutputToContain('Dispatched related posts jobs for 1 posts')
        ->assertExitCode(0);

    Bus::assertDispatched(ComputeRelatedPostsJob::class, function ($job) use ($postWithEmbedding) {
        return $job->post->id === $postWithEmbedding->id;
    });

    Bus::assertNotDispatched(ComputeRelatedPostsJob::class, function ($job) use ($postWithoutEmbedding) {
        return $job->post->id === $postWithoutEmbedding->id;
    });
});
