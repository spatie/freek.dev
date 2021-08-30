<?php

use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Factories\PostFactory;
use Tests\TestCase;

uses(TestCase::class);
uses(MatchesSnapshots::class);

beforeEach(function () {
    parent::setUp();

    $this->post = Post::factory()->create();
});

it('can find a post by its id slug', function () {
    $this->withoutExceptionHandling();

    $this
        ->get(action(PostController::class, $this->post->idSlug()))
        ->assertSuccessful()
        ->assertSee($this->post->title);
});

it('can redirects a slug to an id slug', function () {
    $this
        ->get(action(PostController::class, $this->post->slug))
        ->assertRedirect(action(PostController::class, $this->post->idSlug()));
});

it('will return a 404 for an invalid slug', function () {
    $this
        ->get(action(PostController::class, 'invalid'))
        ->assertNotFound();
});

it('will only show posts with a publish date in the future', function () {
    $post = Post::factory()->create([
        'published' => false,
    ]);

    $this
        ->get(action(PostController::class, $post->idSlug()))
        ->assertNotFound();
});

it('will display unpublished post using a preview secret', function () {
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
});

it('can render a series toc and next link on post', function () {
    $posts = PostFactory::series(10);

    ray()->newScreen('rendering');

    $this->assertMatchesHtmlSnapshot($posts->first()->refresh()->html);
});

it('can get the twitter handle of the author', function () {
    /** @var Post $post */
    $post = Post::factory()->create(['author_twitter_handle' => null]);
    $this->assertNull($post->authorTwitterHandle());

    $user = User::factory()->create(['twitter_handle' => 'other']);
    $post->update(['submitted_by_user_id' => $user->id]);
    $this->assertEquals('other', $post->refresh()->authorTwitterHandle());

    $post->update(['author_twitter_handle' => 'freekmurze']);
    $this->assertEquals('freekmurze', $post->authorTwitterHandle());
});
