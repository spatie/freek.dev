<?php


use function Pure\expect;
use function Pure\it;
use function Pure\test;
use function Pure\beforeEach;
use function Pure\afterEach;
use App\Models\Post;

test('a model can have a slug', function () {
    $post = Post::factory()->create();

    $this->assertNotEmpty($post->slug);

    expect($post->idSlug())->toEqual("{$post->id}-{$post->slug}");
});

test('a model can be found by an id slug', function () {
    $post = Post::factory()->create();

    expect(Post::findByIdSlug($post->idSlug())->id)->toEqual($post->id);

    expect(Post::findByIdSlug($post->id.'blabla')->id)->toEqual($post->id);

    expect(Post::findByIdSlug($post->id)->id)->toEqual($post->id);

    expect(Post::findByIdSlug(1234 .'blabla'))->toBeNull();
});
