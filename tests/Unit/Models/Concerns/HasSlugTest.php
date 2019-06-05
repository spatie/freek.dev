<?php

namespace Tests\Unit\Models\Concerns;

use App\Models\Post;
use Tests\TestCase;

class HasSlugTest extends TestCase
{
    /** @test */
    public function a_model_can_have_a_slug()
    {
        $post = factory(Post::class)->create();

        $this->assertNotEmpty($post->slug);

        $this->assertEquals("{$post->id}-{$post->slug}", $post->idSlug());
    }

    /** @test */
    public function a_model_can_be_found_by_an_id_slug()
    {
        $post = factory(Post::class)->create();

        $this->assertEquals($post->id, Post::findByIdSlug($post->idSlug())->id);

        $this->assertEquals($post->id, Post::findByIdSlug($post->id . 'blabla')->id);

        $this->assertEquals($post->id, Post::findByIdSlug($post->id)->id);

        $this->assertNull(Post::findByIdSlug(1234 . 'blabla'));
    }
}
