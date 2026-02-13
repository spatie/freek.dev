<?php

use App\Models\Post;
use App\Services\PopularPostsService;
use Illuminate\Support\Facades\Cache;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Fakes\Analytics as FakeAnalytics;

it('returns popular posts from cache in order', function () {
    $postA = Post::factory()->create([
        'title' => 'Popular Post A',
        'published' => true,
        'publish_date' => now()->subDays(3),
    ]);

    $postB = Post::factory()->create([
        'title' => 'Popular Post B',
        'published' => true,
        'publish_date' => now()->subDays(2),
    ]);

    $postC = Post::factory()->create([
        'title' => 'Popular Post C',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Cache::put('popular_posts', [$postB->id, $postC->id, $postA->id], 86400);

    $service = new PopularPostsService;
    $posts = $service->getPopularPosts();

    expect($posts)->toHaveCount(3);
    expect($posts->pluck('id')->toArray())->toBe([$postB->id, $postC->id, $postA->id]);
});

it('returns empty collection when cache is empty', function () {
    $service = new PopularPostsService;
    $posts = $service->getPopularPosts();

    expect($posts)->toBeEmpty();
});

it('respects limit parameter', function () {
    $posts = Post::factory()->count(5)->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Cache::put('popular_posts', $posts->pluck('id')->toArray(), 86400);

    $service = new PopularPostsService;
    $popularPosts = $service->getPopularPosts(3);

    expect($popularPosts)->toHaveCount(3);
});

it('excludes unpublished posts from results', function () {
    $publishedPost = Post::factory()->create([
        'title' => 'Published Popular Post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $unpublishedPost = Post::factory()->create([
        'title' => 'Unpublished Popular Post',
        'published' => false,
    ]);

    Cache::put('popular_posts', [$publishedPost->id, $unpublishedPost->id], 86400);

    $service = new PopularPostsService;
    $posts = $service->getPopularPosts();

    expect($posts)->toHaveCount(1);
    expect($posts->first()->id)->toBe($publishedPost->id);
});

it('refreshes cache from analytics data', function () {
    $postA = Post::factory()->create([
        'title' => 'Analytics Popular A',
        'published' => true,
        'publish_date' => now()->subDays(2),
    ]);

    $postB = Post::factory()->create([
        'title' => 'Analytics Popular B',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Analytics::swap(new FakeAnalytics(collect([
        ['pageTitle' => 'Analytics Popular A', 'fullPageUrl' => "https://freek.dev/{$postA->id}-analytics-popular-a", 'screenPageViews' => 500],
        ['pageTitle' => 'Analytics Popular B', 'fullPageUrl' => "https://freek.dev/{$postB->id}-analytics-popular-b", 'screenPageViews' => 300],
        ['pageTitle' => 'Homepage', 'fullPageUrl' => 'https://freek.dev/', 'screenPageViews' => 1000],
    ])));

    $service = new PopularPostsService;
    $service->refreshCache();

    $cachedIds = Cache::get('popular_posts');

    expect($cachedIds)->toContain($postA->id);
    expect($cachedIds)->toContain($postB->id);
    expect($cachedIds)->toHaveCount(2);
});

it('handles analytics api errors gracefully', function () {
    Cache::forget('popular_posts');

    Analytics::swap(new class
    {
        public function __call($method, $args): never
        {
            throw new \RuntimeException('API error');
        }
    });

    $service = new PopularPostsService;
    $service->refreshCache();

    expect(Cache::get('popular_posts'))->toBeNull();
});

it('extracts post ids from various url formats', function () {
    $post = Post::factory()->create([
        'title' => 'URL Format Test Post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Analytics::swap(new FakeAnalytics(collect([
        ['pageTitle' => 'Post', 'fullPageUrl' => "https://freek.dev/{$post->id}-my-slug", 'screenPageViews' => 100],
        ['pageTitle' => 'Not a post', 'fullPageUrl' => 'https://freek.dev/tags/laravel', 'screenPageViews' => 50],
        ['pageTitle' => 'Another non-post', 'fullPageUrl' => 'https://freek.dev/originals', 'screenPageViews' => 40],
    ])));

    $service = new PopularPostsService;
    $service->refreshCache();

    $cachedIds = Cache::get('popular_posts');

    expect($cachedIds)->toBe([$post->id]);
});

it('handles schemeless urls from google analytics', function () {
    $post = Post::factory()->create([
        'title' => 'Schemeless URL Post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Analytics::swap(new FakeAnalytics(collect([
        ['pageTitle' => 'Post', 'fullPageUrl' => "freek.dev/{$post->id}-schemeless-url-post", 'screenPageViews' => 100],
    ])));

    $service = new PopularPostsService;
    $service->refreshCache();

    $cachedIds = Cache::get('popular_posts');

    expect($cachedIds)->toBe([$post->id]);
});

it('deduplicates post ids in cache', function () {
    $post = Post::factory()->create([
        'title' => 'Duplicate Test Post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Analytics::swap(new FakeAnalytics(collect([
        ['pageTitle' => 'Post Page 1', 'fullPageUrl' => "https://freek.dev/{$post->id}-my-slug", 'screenPageViews' => 100],
        ['pageTitle' => 'Post Page 2', 'fullPageUrl' => "https://freek.dev/{$post->id}-my-slug?ref=twitter", 'screenPageViews' => 50],
    ])));

    $service = new PopularPostsService;
    $service->refreshCache();

    $cachedIds = Cache::get('popular_posts');

    expect($cachedIds)->toBe([$post->id]);
});
