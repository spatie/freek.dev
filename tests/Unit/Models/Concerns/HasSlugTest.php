<?php

use App\Models\Post;
use Tests\TestCase;

uses(TestCase::class);

test('a model can have a slug', function () {
    $post = Post::factory()->create();

    $this->assertNotEmpty($post->slug);

    $this->assertEquals("{$post->id}-{$post->slug}", $post->idSlug());
});

test('a model can be found by an id slug', function () {
    $post = Post::factory()->create();

    $this->assertEquals($post->id, Post::findByIdSlug($post->idSlug())->id);

    $this->assertEquals($post->id, Post::findByIdSlug($post->id . 'blabla')->id);

    $this->assertEquals($post->id, Post::findByIdSlug($post->id)->id);

    $this->assertNull(Post::findByIdSlug(1234 . 'blabla'));
});
