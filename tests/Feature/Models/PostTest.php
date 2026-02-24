<?php

use App\Models\Post;
use App\Models\User;
use Tests\Factories\PostFactory;

use function Pest\Laravel\get;

beforeEach(function () {
    $this->post = Post::factory()->create([
        'published' => true,
    ]);
});

it('can find a post by its id slug', function () {
    get('/'.$this->post->idSlug())
        ->assertSuccessful()
        ->assertSee($this->post->title);
});

it('will return a 404 for an invalid slug', function () {
    get('/this-post-does-not-exist')
        ->assertNotFound();
});

it('will only show published posts', function () {
    $post = Post::factory()->create([
        'published' => false,
    ]);

    get('/'.$post->idSlug())->assertNotFound();
});

it('will display unpublished post using a preview secret', function () {

    $post = Post::factory()->create([
        'published' => false,
    ]);

    get('/'.$post->idSlug())
        ->assertNotFound();

    get('/'.$post->idSlug()."?preview_secret={$post->preview_secret}")
        ->assertSuccessful();

    get('/'.$post->idSlug().'?preview_secret=wrong-secret')
        ->assertNotFound();
});

it('can render a series toc and next link on post', function () {
    $posts = PostFactory::series(10);

    $html = $posts->first()->refresh()->html;

    expect($html)
        ->toContain('This post is a part of a series')
        ->toContain('Part 0: Lorem ipsum <span class="font-italic font-light">(you are here)')
        ->toContain('This is the blog post This series is continued in');

    foreach ($posts->skip(1)->values() as $index => $post) {
        $partNumber = $index + 1;
        expect($html)->toContain("/{$post->idSlug()}\">Part {$partNumber}: Lorem ipsum</a>");
    }
});

it('renders og image template on post page', function () {
    get('/'.$this->post->idSlug())
        ->assertSuccessful()
        ->assertSee('data-og-image', false);
});

it('does not render post og image template for tweet posts', function () {
    $tweet = Post::factory()->create([
        'published' => true,
        'title' => 'A unique tweet title for testing',
    ]);
    $tweet->attachTag('tweet');

    $response = get('/'.$tweet->idSlug())->assertSuccessful();

    $content = $response->getContent();
    $templateMatches = [];
    preg_match_all('/<template[^>]*data-og-image[^>]*>(.*?)<\/template>/s', $content, $templateMatches);

    foreach ($templateMatches[1] as $templateContent) {
        expect($templateContent)->not->toContain('A unique tweet title for testing');
    }
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
