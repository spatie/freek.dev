<?php

use App\Models\Post;

use function Pest\Laravel\get;

it('can display the archive page with posts grouped by year and month', function () {
    Post::factory()->create([
        'title' => 'Archive post from January 2024',
        'published' => true,
        'publish_date' => '2024-01-15',
    ]);

    Post::factory()->create([
        'title' => 'Archive post from March 2024',
        'published' => true,
        'publish_date' => '2024-03-10',
    ]);

    Post::factory()->create([
        'title' => 'Archive post from January 2025',
        'published' => true,
        'publish_date' => '2025-01-05',
    ]);

    get('/archive')
        ->assertOk()
        ->assertSee('Archive post from January 2024')
        ->assertSee('Archive post from March 2024')
        ->assertSee('Archive post from January 2025')
        ->assertSee('2024')
        ->assertSee('2025')
        ->assertSee('January')
        ->assertSee('March');
});

it('does not show unpublished posts on the archive page', function () {
    Post::factory()->create([
        'title' => 'A published archive post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Post::factory()->create([
        'title' => 'An unpublished archive post',
        'published' => false,
        'publish_date' => null,
    ]);

    get('/archive')
        ->assertOk()
        ->assertSee('A published archive post')
        ->assertDontSee('An unpublished archive post');
});

it('shows an empty archive page when there are no posts', function () {
    get('/archive')
        ->assertOk();
});
