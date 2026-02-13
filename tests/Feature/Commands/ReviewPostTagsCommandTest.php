<?php

use App\Models\Post;
use App\Services\TaggingService;

it('reviews and updates tags for published posts', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $post->syncTags(['php']);
    $post->refresh();

    $taggingService = Mockery::mock(TaggingService::class);
    $taggingService->shouldReceive('generateTags')
        ->once()
        ->andReturn(['php', 'laravel']);

    $this->app->instance(TaggingService::class, $taggingService);

    $this->artisan('app:review-post-tags')
        ->assertExitCode(0);

    $post->refresh();

    expect($post->tags->pluck('name')->sort()->values()->all())
        ->toBe(['laravel', 'php']);
});

it('does not update tags in dry-run mode', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $post->syncTags(['php']);
    $post->refresh();

    $taggingService = Mockery::mock(TaggingService::class);
    $taggingService->shouldReceive('generateTags')
        ->once()
        ->andReturn(['php', 'laravel']);

    $this->app->instance(TaggingService::class, $taggingService);

    $this->artisan('app:review-post-tags --dry-run')
        ->assertExitCode(0);

    $post->refresh();

    expect($post->tags->pluck('name')->sort()->values()->all())
        ->toBe(['php']);
});

it('can review a specific post by id', function () {
    $post1 = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(2),
    ]);
    $post1->syncTags(['php']);

    $post2 = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);
    $post2->syncTags(['javascript']);

    $taggingService = Mockery::mock(TaggingService::class);
    $taggingService->shouldReceive('generateTags')
        ->once()
        ->andReturn(['php', 'laravel']);

    $this->app->instance(TaggingService::class, $taggingService);

    $this->artisan("app:review-post-tags --post={$post1->id}")
        ->assertExitCode(0);

    $post1->refresh();
    $post2->refresh();

    expect($post1->tags->pluck('name')->sort()->values()->all())
        ->toBe(['laravel', 'php']);

    expect($post2->tags->pluck('name')->sort()->values()->all())
        ->toBe(['javascript']);
});

it('skips posts where tags are already correct', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $post->syncTags(['laravel', 'php']);
    $post->refresh();

    $taggingService = Mockery::mock(TaggingService::class);
    $taggingService->shouldReceive('generateTags')
        ->once()
        ->andReturn(['laravel', 'php']);

    $this->app->instance(TaggingService::class, $taggingService);

    $this->artisan('app:review-post-tags')
        ->expectsOutputToContain('0 post(s) updated')
        ->assertExitCode(0);

    $post->refresh();

    expect($post->tags->pluck('name')->sort()->values()->all())
        ->toBe(['laravel', 'php']);
});
