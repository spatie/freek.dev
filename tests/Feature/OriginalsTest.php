<?php

use App\Models\Post;

it('introduces originals above the articles without repeating their author or category', function () {
    $post = Post::factory()->create([
        'title' => 'An original article',
        'author' => 'Original Writer',
        'original_content' => true,
        'publish_date' => now()->subDay(),
        'text' => 'An excerpt with [a useful package](https://example.com/package).<!--more-->More detail.',
    ]);

    $link = Post::factory()->create(['original_content' => false]);

    $this->get('/originals')
        ->assertOk()
        ->assertSeeInOrder(["In this section you can read posts I've written myself.", $post->title])
        ->assertSee('href="'.$post->url.'"', false)
        ->assertSee('a useful package')
        ->assertSee('minute read')
        ->assertDontSee('>original</span>', false)
        ->assertDontSee('by Original Writer')
        ->assertDontSee($link->title);
});

it('keeps original badges and authors outside the originals listing', function (string $page) {
    $post = Post::factory()->create([
        'author' => 'Original Writer',
        'original_content' => true,
        'publish_date' => now()->subDay(),
    ]);

    $this->get($page === 'post' ? $post->url : '/')
        ->assertOk()
        ->assertSee('>original</span>', false)
        ->assertSee('by Original Writer');
})->with(['home', 'post']);
