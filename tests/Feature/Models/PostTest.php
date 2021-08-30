<?php

use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\User;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\Factories\PostFactory;
use Tests\TestCase;
use function \Pest\Laravel\get;

beforeEach(function () {
    $this->post = Post::factory()->create();
});

it('can find a post by its id slug', function () {
    $this->withoutExceptionHandling();

    get(action(PostController::class, $this->post->idSlug()))
        ->assertSuccessful()
        ->assertSee($this->post->title);
});

it('can redirects a slug to an id slug', function () {
    get(action(PostController::class, $this->post->slug))
        ->assertRedirect(action(PostController::class, $this->post->idSlug()));
});

it('will return a 404 for an invalid slug', function () {
    get(action(PostController::class, 'invalid'))
        ->assertNotFound();
});

it('will only show posts with a publish date in the future', function () {
    $post = Post::factory()->create([
        'published' => false,
    ]);

    get(action(PostController::class, $post->idSlug()))
        ->assertNotFound();
});

it('will display unpublished post using a preview secret', function () {
    $post = Post::factory()->create([
        'published' => false,
    ]);

    get(action(PostController::class, $post->idSlug()))
        ->assertNotFound();

    get(action(PostController::class, $post->idSlug()) . "?preview_secret={$post->preview_secret}")
        ->assertSuccessful();

    get(action(PostController::class, $post->idSlug()) . "?preview_secret=wrong-secret")
        ->assertNotFound();
});

it('can render a series toc and next link on post', function () {
    $posts = PostFactory::series(10);

    expect($posts->first()->refresh()->html)->toMatchSnapshot();
});

it('can get the twitter handle of the author', function () {
    /** @var Post $post */
    $post = Post::factory()->create(['author_twitter_handle' => null]);
    expect($post->authorTwitterHandle())->toBeNull();

    $user = User::factory()->create(['twitter_handle' => 'other']);
    $post->update(['submitted_by_user_id' => $user->id]);
    expect($post->refresh()->authorTwitterHandle())->toEqual('other');

    $post->update(['author_twitter_handle' => 'freekmurze']);
    expect($post->authorTwitterHandle())->toEqual('freekmurze');
});
