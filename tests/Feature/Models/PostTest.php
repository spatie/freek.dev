<?php

use App\Http\Controllers\Discovery\Post\ShowPostController;
use App\Models\Post;
use App\Models\User;
use Tests\Factories\PostFactory;
use function \Pest\Laravel\get;

beforeEach(function () {
    $this->post = Post::factory()->create();
});

it('can find a post by its id slug', function () {
    $this->withoutExceptionHandling();

    get(action(ShowPostController::class, $this->post->idSlug()))
        ->assertSuccessful()
        ->assertSee($this->post->title);
});

it('will return a 404 for an invalid slug', function () {
    get(action(ShowPostController::class, 'invalid'))
        ->assertNotFound();
});

it('will only show posts with a publish date in the future', function () {
    $post = Post::factory()->create([
        'published' => false,
    ]);

    get(action(ShowPostController::class, $post->idSlug()))
        ->assertNotFound();
});

it('will display unpublished post using a preview secret', function () {
    $post = Post::factory()->create([
        'published' => false,
    ]);

    get(action(ShowPostController::class, $post->idSlug()))
        ->assertNotFound();

    get(action(ShowPostController::class, $post->idSlug()) . "?preview_secret={$post->preview_secret}")
        ->assertSuccessful();

    get(action(ShowPostController::class, $post->idSlug()) . "?preview_secret=wrong-secret")
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
