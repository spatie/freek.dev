<?php

namespace Tests\Unit\Models;

use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    /** @test */
    public function it_can_determine_the_promotional_url()
    {
        $post = factory(Post::class)->create([
            'title' => 'test',
        ]);
        $this->assertEquals(
            "http://freek.dev.test/{$post->id}-test",
            $post->promotional_url,
            );

        $post = factory(Post::class)->create([
            'title' => 'test',
            'external_url' => 'https://external-blog.com/page'
        ]);
        $this->assertEquals(
            'https://external-blog.com/page',
            $post->promotional_url,
            );
    }

    /** @test */
    public function it_can_get_scheduled_posts()
    {
        $this->assertCount(0, Post::scheduled()->get());

        factory(Post::class)->create([
            'publish_date' => now()->subMinute(),
            'published' => false,
        ]);
        $this->assertCount(1, Post::scheduled()->get());

        factory(Post::class)->create([
            'publish_date' => now()->subMinute(),
            'published' => true,
        ]);
        $this->assertCount(1, Post::scheduled()->get());

        factory(Post::class)->create([
            'publish_date' => now()->addMinute(),
            'published' => false,
        ]);
        $this->assertCount(2, Post::scheduled()->get());

        factory(Post::class)->create([
            'publish_date' => null,
            'published' => false,
        ]);
        $this->assertCount(2, Post::scheduled()->get());
    }

    /** @test */
    public function it_can_determine_if_the_post_concerns_a_tweet()
    {
        $post = factory(Post::class)->create();

        $this->assertFalse($post->isTweet());

        $post->syncTags(['php', 'tweet']);

        $this->assertTrue($post->refresh()->isTweet());
    }

    /** @test */
    public function it_can_determine_that_a_post_is_a_tweet()
    {
        $post = factory(Post::class)->create();
        $this->assertFalse($post->isTweet());

        $post = factory(Post::class)->create()->attachTag('tweet');
        $this->assertTrue($post->isTweet());

        $post = factory(Post::class)->create()->attachTags([
            'tag',
            'tweet',
            'another-tag'
        ]);
        $this->assertTrue($post->isTweet());
    }

    /** @test */
    public function it_can_determine_the_excerpt()
    {
        $post = factory(Post::class)->create([
           'text' => 'excerpt<!--more-->full post',
        ]);

        $this->assertEquals('<p>excerpt</p>', $post->excerpt);
    }
}
