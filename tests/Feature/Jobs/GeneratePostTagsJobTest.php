<?php

use App\Jobs\GeneratePostTagsJob;
use App\Models\Post;
use App\Services\TaggingService;

it('generates and syncs tags for a post without tags', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $taggingService = Mockery::mock(TaggingService::class);
    $taggingService->shouldReceive('generateTags')
        ->once()
        ->with(Mockery::on(fn ($arg) => $arg->id === $post->id))
        ->andReturn(['php', 'laravel']);

    $job = new GeneratePostTagsJob($post);
    $job->handle($taggingService);

    $post->refresh();

    expect($post->tags->pluck('name')->sort()->values()->all())
        ->toBe(['laravel', 'php']);
});

it('skips tagging if post already has tags', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $post->syncTags(['existing-tag']);
    $post->refresh();

    $taggingService = Mockery::mock(TaggingService::class);
    $taggingService->shouldNotReceive('generateTags');

    $job = new GeneratePostTagsJob($post);
    $job->handle($taggingService);

    expect($post->tags)->toHaveCount(1);
    expect($post->tags->first()->name)->toBe('existing-tag');
});
