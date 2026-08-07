<?php

use App\Models\Post;

use function Pest\Laravel\get;

function postWithKnownExcerpt(array $attributes = []): Post
{
    return Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
        'original_content' => true,
        'text' => 'A short and very recognisable excerpt.',
        ...$attributes,
    ]);
}

it('renders a meta description on a post page', function () {
    $post = postWithKnownExcerpt();

    get($post->url)
        ->assertOk()
        ->assertSee('<meta name="description" content="'.$post->plain_text_excerpt.'">', false);
});

it('keeps the site wide og tags on a page that fills the seo slot', function () {
    $post = postWithKnownExcerpt();

    get($post->url)
        ->assertOk()
        ->assertSee('<meta property="og:site_name" content="freek.dev">', false)
        ->assertSee('<meta property="og:locale" content="en_US">', false)
        ->assertSee('<meta property="og:type" content="article"/>', false);
});

it('does not render duplicate og description or og url tags on a post page', function () {
    $post = postWithKnownExcerpt();

    $content = get($post->url)->assertOk()->getContent();

    expect(substr_count($content, '<meta property="og:description"'))->toBe(1)
        ->and(substr_count($content, '<meta property="og:url"'))->toBe(1)
        ->and(substr_count($content, '<meta name="description"'))->toBe(1);
});

it('falls back to the site wide description on a page without its own description', function () {
    postWithKnownExcerpt();

    get('/')
        ->assertOk()
        ->assertSee('<meta name="description" content="Freek Van der Herten writes about Laravel, PHP and AI.', false);
});

it('points the favicon at the site root so it resolves on nested urls', function () {
    $post = postWithKnownExcerpt();

    get($post->url)
        ->assertOk()
        ->assertSee('<link rel="shortcut icon" href="/favicon.ico"', false);
});

it('strips the query string from og url', function () {
    Post::factory()->count(25)->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    get('/?page=2')
        ->assertOk()
        ->assertSee('<meta property="og:url" content="'.url('/').'">', false);
});
