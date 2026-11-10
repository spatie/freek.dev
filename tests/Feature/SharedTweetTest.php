<?php

use App\Models\Post;
use App\Models\User;
use App\Services\CommonMark\CommonMark;
use App\Services\NewsletterGenerator;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Sanctum::actingAs(User::factory()->admin()->create());

    $this->tweet = [
        'title' => 'APIs built for agents',
        'shared_tweet_url' => 'https://x.com/jsharkey/status/2107225649396281618',
        'shared_tweet_author' => 'Jack Sharkey',
        'shared_tweet_text' => "Every public API should have a feedback endpoint for agents.\n\nLet the agents work!",
    ];

    Http::preventStrayRequests();
});

it('creates a tweet without a comment or special tag and includes it in the feed', function () {
    $response = $this->callPostTool('create-post', $this->tweet + ['published' => true, 'publish_date' => now()->toIso8601String()])
        ->assertSuccessful()
        ->assertJsonPath('result.isError', false)
        ->assertJsonPath('result.structuredContent.post.type', Post::TYPE_TWEET)
        ->assertJsonPath('result.structuredContent.post.text', '')
        ->assertJsonPath('result.structuredContent.post.shared_tweet_text', $this->tweet['shared_tweet_text']);

    $post = Post::findOrFail($response->json('result.structuredContent.post.id'));

    expect($post->toFeedItem()->summary)
        ->toContain('Every public API', 'https://x.com/jsharkey/status/2107225649396281618')
        ->not->toContain('twitter-tweet', 'data-lazy', '<script');

    Http::assertNothingSent();
});

it('imports a tweet from a URL and preserves Unicode and line breaks without executing HTML', function () {
    Http::fake(['publish.x.com/oembed*' => Http::response([
        'author_name' => 'Jack Sharkey',
        'html' => '<blockquote><p>Build APIs for agents 🚀<br><br>&lt;script&gt;not executable&lt;/script&gt;</p></blockquote><script>bad()</script>',
    ])]);

    $this->callPostTool('create-post', [
        'title' => 'APIs for agents',
        'shared_tweet_url' => $this->tweet['shared_tweet_url'],
    ])->assertSuccessful()
        ->assertJsonPath('result.structuredContent.post.shared_tweet_author', 'Jack Sharkey')
        ->assertJsonPath('result.structuredContent.post.shared_tweet_text', "Build APIs for agents 🚀\n\n<script>not executable</script>");
});

it('returns a useful validation error when X cannot import a tweet', function () {
    Http::fake(['publish.x.com/oembed*' => Http::response('', 404)]);

    $response = $this->callPostTool('create-post', [
        'title' => 'Missing tweet',
        'shared_tweet_url' => $this->tweet['shared_tweet_url'],
    ])->assertSuccessful()->assertJsonPath('result.isError', true);

    expect($response->json('result.content.0.text'))->toContain('X could not load', 'author', 'tweet text');
    expect(Post::count())->toBe(0);
});

it('rejects non-tweet URLs before attempting an import', function (string $url) {
    $response = $this->callPostTool('create-post', array_replace($this->tweet, ['shared_tweet_url' => $url]))
        ->assertSuccessful()->assertJsonPath('result.isError', true);

    expect($response->json('result.content.0.text'))->toContain('Use a tweet URL', 'https://x.com/username/status/123');
    Http::assertNothingSent();
})->with([
    'https://example.com/jsharkey/status/123',
    'https://x.com.evil.test/jsharkey/status/123',
    'https://x.com/jsharkey',
    'javascript:alert(1)',
]);

it('updates a comment without losing the tweet and allows removing the comment', function () {
    $post = Post::factory()->create($this->tweet + ['text' => 'My take', 'original_content' => true]);

    $this->callPostTool('update-post', ['id' => $post->id, 'text' => '**A better take.**'])
        ->assertOk()->assertJsonPath('result.structuredContent.post.shared_tweet_text', $this->tweet['shared_tweet_text'])
        ->assertJsonPath('result.structuredContent.post.original_content', false);

    $this->callPostTool('update-post', ['id' => $post->id, 'text' => null])
        ->assertOk()->assertJsonPath('result.structuredContent.post.text', '');

    $response = $this->callPostTool('update-post', ['id' => $post->id, 'shared_tweet_text' => null])
        ->assertSuccessful()->assertJsonPath('result.isError', true);

    expect($response->json('result.content.0.text'))->toContain('shared tweet text', 'required');
    Http::assertNothingSent();
});

it('replaces the snapshot when changing the tweet URL', function () {
    $post = Post::factory()->create($this->tweet);

    Http::fake(['publish.x.com/oembed*' => Http::response([
        'author_name' => 'Another author',
        'html' => '<blockquote><p>A different tweet.</p></blockquote>',
    ])]);

    $this->callPostTool('update-post', ['id' => $post->id, 'shared_tweet_url' => 'https://twitter.com/other/status/456'])
        ->assertOk()->assertJsonPath('result.structuredContent.post.shared_tweet_author', 'Another author')
        ->assertJsonPath('result.structuredContent.post.shared_tweet_text', 'A different tweet.');
});

it('requires a body when converting a tweet into a regular post', function () {
    $post = Post::factory()->create($this->tweet + ['text' => '']);

    $this->callPostTool('update-post', ['id' => $post->id, 'shared_tweet_url' => null])
        ->assertJsonPath('result.isError', true);

    expect($post->refresh()->shared_tweet_url)->toBe($this->tweet['shared_tweet_url']);

    $this->callPostTool('update-post', [
        'id' => $post->id, 'shared_tweet_url' => null, 'text' => 'A regular post body.',
    ])->assertJsonPath('result.structuredContent.post.type', Post::TYPE_LINK)
        ->assertJsonPath('result.structuredContent.post.text', 'A regular post body.');

    Http::assertNothingSent();
});

it('renders the tweet and optional comment on the homepage and post page safely', function () {
    $post = Post::factory()->create(array_replace($this->tweet, [
        'text' => 'My **take** on this.',
        'shared_tweet_text' => '<script>alert("no")</script>',
        'published' => true,
        'publish_date' => now(),
    ]));

    foreach ([route('home'), $post->url] as $url) {
        $this->get($url)->assertOk()
            ->assertSee('Jack Sharkey')->assertSee('@jsharkey')
            ->assertSee('My <strong>take</strong> on this.', false)
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert("no")</script>', false)
            ->assertSee('class="twitter-tweet"', false)
            ->assertSee('data-dnt="true"', false)
            ->assertSee('data-conversation="none"', false)
            ->assertSee('data-lazy="twitter"', false)
            ->assertSee('Read on X');
    }
});

it('includes only published tweets in the selected newsletter period and separates them from articles', function () {
    $start = now()->startOfDay()->subWeek();
    $end = now()->endOfDay();

    Post::factory()->create($this->tweet + ['publish_date' => $start->copy(), 'published' => true, 'text' => 'Useful for APIs & agents.']);
    Post::factory()->create(array_replace($this->tweet, ['title' => 'No comment', 'shared_tweet_text' => 'On the final day.', 'publish_date' => $end->copy(), 'text' => '', 'published' => true]));
    Post::factory()->create(array_replace($this->tweet, ['shared_tweet_text' => 'Unpublished tweet', 'published' => false, 'publish_date' => $start->copy()]));
    Post::factory()->create(array_replace($this->tweet, ['shared_tweet_text' => 'Outside period', 'publish_date' => $start->copy()->subSecond()]));
    Post::factory()->create(['title' => 'An article', 'text' => 'Article text.', 'publish_date' => $start->copy(), 'original_content' => false]);

    $generator = new NewsletterGenerator($start, $end, 352);
    $markdown = $generator->getMarkdown();
    $html = CommonMark::convertToHtml($markdown);

    expect($markdown)->toContain('# Noteworthy tweets', 'Jack Sharkey', 'On the final day.', '<strong>My take:</strong> Useful for APIs &amp; agents.')
        ->not->toContain('Unpublished tweet', 'Outside period', '[APIs built for agents]');
    expect($html)->toContain('<table role="presentation"', 'Read the original tweet')
        ->not->toContain('&lt;table', '&amp;amp;', '<script', 'twitter-tweet', 'data-lazy');
    expect($generator->getMarkdown())->toBe($markdown);
});

it('omits the newsletter heading when there are no tweets and supports legacy tagged tweets', function () {
    $render = fn () => (new NewsletterGenerator(now()->subWeek(), now(), 352))->getMarkdown();

    expect($render())->not->toContain('Noteworthy tweets');

    $legacy = Post::factory()->create(['title' => 'Legacy tweet', 'text' => 'Legacy excerpt.', 'publish_date' => now()]);
    $legacy->attachTag('tweet');

    expect($render())->toContain('# Noteworthy tweets', '[Legacy tweet]', 'Legacy excerpt.');
});
