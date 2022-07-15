<?php

use App\Models\Post;

it('can determine the promotional url', function () {
    $post = Post::factory()->create([
        'title' => 'test',
    ]);
    $this->assertEquals(
        "http://freek.dev.test/{$post->id}-test",
        $post->promotional_url,
    );

    $post = Post::factory()->create([
        'title' => 'test',
        'external_url' => 'https://external-blog.com/page',
    ]);
    $this->assertEquals(
        'https://external-blog.com/page',
        $post->promotional_url,
    );
});

it('can get scheduled posts', function () {
    expect(Post::scheduled()->get())->toHaveCount(0);

    Post::factory()->create([
        'publish_date' => now()->subMinute(),
        'published' => false,
    ]);
    expect(Post::scheduled()->get())->toHaveCount(1);

    Post::factory()->create([
        'publish_date' => now()->subMinute(),
        'published' => true,
    ]);
    expect(Post::scheduled()->get())->toHaveCount(1);

    Post::factory()->create([
        'publish_date' => now()->addMinute(),
        'published' => false,
    ]);
    expect(Post::scheduled()->get())->toHaveCount(2);

    Post::factory()->create([
        'publish_date' => null,
        'published' => false,
    ]);
    expect(Post::scheduled()->get())->toHaveCount(2);
});

it('can determine if the post concerns a tweet', function () {
    $post = Post::factory()->create();

    expect($post->isTweet())->toBeFalse();

    $post->syncTags(['php', 'tweet']);

    expect($post->refresh()->isTweet())->toBeTrue();
});

it('can determine that a post is a tweet', function () {
    $post = Post::factory()->create();
    expect($post->isTweet())->toBeFalse();

    $post = Post::factory()->create()->attachTag('tweet');
    expect($post->isTweet())->toBeTrue();

    $post = Post::factory()->create()->attachTags([
        'tag',
        'tweet',
        'another-tag',
    ]);
    expect($post->isTweet())->toBeTrue();
});

it('can determine the excerpt', function () {
    $post = Post::factory()->create([
        'text' => 'excerpt<!--more-->full post',
    ]);

    expect($post->excerpt)->toEqual('<p>excerpt</p>');
});

test('a post is tweetable', function () {
    /** @var \App\Models\Post $post */
    $post = Post::factory()->create();

    expect(is_string($post->toTweet()))->toBeTrue();
});

it('can save the tweeted url', function () {
    /** @var \App\Models\Post $post */
    $post = Post::factory()->create();

    $url = 'https://twitter.com/freekmurze/status/123';

    $post->onAfterTweet($url);

    expect($post->refresh()->tweet_url)->toEqual($url);
});
