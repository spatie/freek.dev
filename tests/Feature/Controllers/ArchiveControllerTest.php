<?php

use App\Models\Post;

use function Pest\Laravel\get;

it('shows the most recent three years by default', function () {
    Post::factory()->create([
        'title' => 'Post from 2022',
        'published' => true,
        'publish_date' => '2022-01-15',
    ]);

    Post::factory()->create([
        'title' => 'Post from 2023',
        'published' => true,
        'publish_date' => '2023-06-10',
    ]);

    Post::factory()->create([
        'title' => 'Post from 2024',
        'published' => true,
        'publish_date' => '2024-01-15',
    ]);

    Post::factory()->create([
        'title' => 'Post from 2025',
        'published' => true,
        'publish_date' => '2025-03-10',
    ]);

    get('/archive')
        ->assertOk()
        ->assertSee('2025')
        ->assertSee('Post from 2025')
        ->assertSee('2024')
        ->assertSee('Post from 2024')
        ->assertSee('2023')
        ->assertSee('Post from 2023')
        ->assertDontSee('Post from 2022');
});

it('can display a specific year', function () {
    Post::factory()->create([
        'title' => 'Post from 2024',
        'published' => true,
        'publish_date' => '2024-06-15',
    ]);

    Post::factory()->create([
        'title' => 'Post from 2025',
        'published' => true,
        'publish_date' => '2025-01-05',
    ]);

    get('/archive/2024')
        ->assertOk()
        ->assertSee('2024')
        ->assertSee('Post from 2024')
        ->assertDontSee('Post from 2025');
});

it('shows navigation links to adjacent years', function () {
    Post::factory()->create([
        'published' => true,
        'publish_date' => '2023-01-15',
    ]);

    Post::factory()->create([
        'published' => true,
        'publish_date' => '2024-06-15',
    ]);

    Post::factory()->create([
        'published' => true,
        'publish_date' => '2025-01-05',
    ]);

    get('/archive/2024')
        ->assertOk()
        ->assertSee('2023')
        ->assertSee('2025');
});

it('groups posts by month within a year', function () {
    Post::factory()->create([
        'title' => 'January post',
        'published' => true,
        'publish_date' => '2024-01-15',
    ]);

    Post::factory()->create([
        'title' => 'March post',
        'published' => true,
        'publish_date' => '2024-03-10',
    ]);

    get('/archive/2024')
        ->assertOk()
        ->assertSee('January')
        ->assertSee('March')
        ->assertSee('January post')
        ->assertSee('March post');
});

it('does not show unpublished posts', function () {
    Post::factory()->create([
        'title' => 'A published post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Post::factory()->create([
        'title' => 'An unpublished post',
        'published' => false,
        'publish_date' => null,
    ]);

    get('/archive')
        ->assertOk()
        ->assertSee('A published post')
        ->assertDontSee('An unpublished post');
});

it('shows an empty archive page when there are no posts', function () {
    get('/archive')
        ->assertOk();
});
