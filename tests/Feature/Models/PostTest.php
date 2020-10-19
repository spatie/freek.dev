<?php

namespace Tests\Feature\Models;

use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Factories\PostFactory;
use Tests\TestCase;

class PostTest extends TestCase
{
    use MatchesSnapshots;

    private Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create();
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
        $post = Post::factory()->create([
            'published' => false,
        ]);

        $this
            ->get(action(PostController::class, $post->idSlug()))
            ->assertNotFound();
    }

    /** @test */
    public function it_will_display_unpublished_post_using_a_preview_secret()
    {
        $post = Post::factory()->create([
            'published' => false,
        ]);

        $this
            ->get(action(PostController::class, $post->idSlug()))
            ->assertNotFound();

        $this
            ->get(action(PostController::class, $post->idSlug()) . "?preview_secret={$post->preview_secret}")
            ->assertSuccessful();

        $this
            ->get(action(PostController::class, $post->idSlug()) . "?preview_secret=wrong-secret")
            ->assertNotFound();
    }

    /** @test */
    public function it_can_render_a_series_toc_and_next_link_on_post()
    {
        $posts = PostFactory::series(10);

        $this->assertMatchesHtmlSnapshot($posts->first()->formatted_text);
    }

    /** @test */
    public function it_can_get_the_twitter_handle_of_the_author()
    {
        /** @var Post $post */
        $post = Post::factory()->create(['author_twitter_handle' => null]);
        $this->assertNull($post->authorTwitterHandle());

        $user = User::factory()->create(['twitter_handle' => 'other']);
        $post->update(['submitted_by_user_id' => $user->id]);
        $this->assertEquals('other', $post->refresh()->authorTwitterHandle());

        $post->update(['author_twitter_handle' => 'freekmurze']);
        $this->assertEquals('freekmurze', $post->authorTwitterHandle());
    }
}
