<?php

use App\Models\Post;

use function Pest\Laravel\get;

it('adds a self-referencing canonical pointing to the clean url', function () {
    Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    get('/')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="'.url('/').'" />', false);
});

it('strips the query string from the self-referencing canonical', function () {
    Post::factory()->count(25)->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    get('/?page=2')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="'.url('/').'" />', false)
        ->assertDontSee('<link rel="canonical" href="'.url('/?page=2').'" />', false);
});

it('keeps an explicit canonical for link posts pointing to the external url', function () {
    $post = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'original_content' => false,
        'external_url' => 'https://example.com/some-article',
    ]);

    get($post->url)
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://example.com/some-article" />', false);
});

it('uses a self canonical for the Saloon SDK post without changing its source link', function () {
    $post = Post::factory()->create([
        'id' => 2918,
        'published' => true,
        'external_url' => 'https://ohdear.app/news-and-updates/exploring-our-new-php-sdk-built-using-saloon',
    ]);

    get($post->url.'?utm_source=test')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="'.$post->url.'" />', false)
        ->assertSee('href="'.e($post->external_url_with_utm).'"', false);
});
