<?php

namespace Tests\Feature\Jobs;

use App\Jobs\CreateOgImageJob;
use App\Models\Post;
use Tests\TestCase;

class CreatePostOgImageJobTest extends TestCase
{
    /** @test */
    public function it_can_create_an_og_image_for_a_post()
    {
        $post = Post::factory()->create([
            'published' => true,
        ]);

        dispatch_now(new CreateOgImageJob($post));
    }
}
