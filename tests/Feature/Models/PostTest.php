<?php

namespace Tests\Feature\Models;

use App\Http\Controllers\PostController;
use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    private Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = factory(Post::class)->create();
    }

    /** @test */
    public function it_can_find_a_post_by_its_id_slug()
    {
        $this->withoutExceptionHandling();

        $this
            ->get(action(PostController::class, $this->post->idSlug()))
            ->assertSuccessful()
            ->assertSee($this->post->title);
    }

    /** @test */
    public function it_can_redirects_a_slug_to_an_id_slug()
    {
        $this
            ->get(action(PostController::class, $this->post->slug))
            ->assertRedirect(action(PostController::class, $this->post->idSlug()));
    }

    /** @test */
    public function it_will_return_a_404_for_an_invalid_slug()
    {
        $this
            ->get(action(PostController::class, 'invalid'))
            ->assertNotFound();
    }

    /** @test */
    public function it_will_only_show_posts_with_a_publish_date_in_the_future()
    {
        $post = factory(Post::class)->create([
            'published' => false,
        ]);

        $this
            ->get(action(PostController::class, $post->idSlug()))
            ->assertNotFound();
    }
}
