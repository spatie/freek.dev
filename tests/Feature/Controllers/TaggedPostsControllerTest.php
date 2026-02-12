<?php

use App\Models\Post;

use function Pest\Laravel\get;

it('can display posts for a given tag', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);
    $post->attachTag('laravel');

    $otherPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(2),
    ]);
    $otherPost->attachTag('php');

    get('/tags/laravel')
        ->assertOk()
        ->assertSee($post->title)
        ->assertDontSee($otherPost->title);
});

it('returns 404 for a non-existing tag', function () {
    get('/tags/non-existing-tag')
        ->assertNotFound();
});

it('does not show unpublished posts', function () {
    $publishedPost = Post::factory()->create([
        'title' => 'A published tagged post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);
    $publishedPost->attachTag('laravel');

    $unpublishedPost = Post::factory()->create([
        'title' => 'An unpublished tagged post',
        'published' => false,
        'publish_date' => null,
    ]);
    $unpublishedPost->attachTag('laravel');

    get('/tags/laravel')
        ->assertOk()
        ->assertSee($publishedPost->title)
        ->assertDontSee($unpublishedPost->title);
});
