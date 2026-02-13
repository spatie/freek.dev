<?php

use App\Models\Post;
use App\Services\PopularPostsService;

use function Pest\Laravel\get;

it('displays the homepage', function () {
    Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    get('/')
        ->assertOk();
});

it('shows tag pills on the first page', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);
    $post->attachTag('laravel');
    $post->attachTag('php');

    get('/')
        ->assertOk()
        ->assertSee('Browse by category')
        ->assertSee('laravel')
        ->assertSee('php');
});

it('shows popular posts on the first page', function () {
    $popularPost = Post::factory()->create([
        'title' => 'A very popular post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $this->mock(PopularPostsService::class)
        ->shouldReceive('getPopularPosts')
        ->with(8)
        ->andReturn(collect([$popularPost]));

    get('/')
        ->assertOk()
        ->assertSee('Popular content')
        ->assertSee('A very popular post');
});

it('does not show the sidebar on page 2', function () {
    Post::factory()->count(25)->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    get('/?page=2')
        ->assertOk()
        ->assertDontSee('Browse by category')
        ->assertDontSee('Popular content');
});

it('does not include tags from unpublished posts', function () {
    $publishedPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);
    $publishedPost->attachTag('visible-tag');

    $unpublishedPost = Post::factory()->create([
        'published' => false,
        'publish_date' => null,
    ]);
    $unpublishedPost->attachTag('hidden-tag');

    get('/')
        ->assertOk()
        ->assertSee('visible-tag')
        ->assertDontSee('hidden-tag');
});
