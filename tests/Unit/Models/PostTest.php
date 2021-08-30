<?php

use App\Models\Post;
use Tests\TestCase;

uses(TestCase::class);

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
    $this->assertCount(0, Post::scheduled()->get());

    Post::factory()->create([
        'publish_date' => now()->subMinute(),
        'published' => false,
    ]);
    $this->assertCount(1, Post::scheduled()->get());

    Post::factory()->create([
        'publish_date' => now()->subMinute(),
        'published' => true,
    ]);
    $this->assertCount(1, Post::scheduled()->get());

    Post::factory()->create([
        'publish_date' => now()->addMinute(),
        'published' => false,
    ]);
    $this->assertCount(2, Post::scheduled()->get());

    Post::factory()->create([
        'publish_date' => null,
        'published' => false,
    ]);
    $this->assertCount(2, Post::scheduled()->get());
});

it('can determine if the post concerns a tweet', function () {
    $post = Post::factory()->create();

    $this->assertFalse($post->isTweet());

    $post->syncTags(['php', 'tweet']);

    $this->assertTrue($post->refresh()->isTweet());
});

it('can determine that a post is a tweet', function () {
    $post = Post::factory()->create();
    $this->assertFalse($post->isTweet());

    $post = Post::factory()->create()->attachTag('tweet');
    $this->assertTrue($post->isTweet());

    $post = Post::factory()->create()->attachTags([
        'tag',
        'tweet',
        'another-tag',
    ]);
    $this->assertTrue($post->isTweet());
});

it('can determine the excerpt', function () {
    $post = Post::factory()->create([
       'text' => 'excerpt<!--more-->full post',
    ]);

    $this->assertEquals('<p>excerpt</p>', $post->excerpt);
});

test('a post is tweetable', function () {
    /** @var \App\Models\Post $post */
    $post = Post::factory()->create();

    $this->assertTrue(is_string($post->toTweet()));
});

it('can save the tweeted url', function () {
    /** @var \App\Models\Post $post */
    $post = Post::factory()->create();

    $url = 'https://twitter.com/freekmurze/status/123';

    $post->onAfterTweet($url);

    $this->assertEquals($url, $post->refresh()->tweet_url);
});
