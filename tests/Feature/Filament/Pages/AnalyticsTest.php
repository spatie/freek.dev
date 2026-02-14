<?php

use App\Filament\Pages\Analytics;
use App\Filament\Widgets\AnalyticsOverviewStats;
use App\Filament\Widgets\PageViewsChart;
use App\Filament\Widgets\PopularPostsTable;
use App\Filament\Widgets\TopCountriesTable;
use App\Filament\Widgets\TopReferrersTable;
use App\Models\Post;
use App\Models\User;
use App\Services\AnalyticsService;
use Livewire\Livewire;
use Spatie\Analytics\Facades\Analytics as AnalyticsFacade;
use Spatie\Analytics\Fakes\Analytics as FakeAnalytics;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);

    AnalyticsFacade::swap(new FakeAnalytics(collect([
        ['date' => now(), 'activeUsers' => 100, 'screenPageViews' => 500],
        ['date' => now()->subDay(), 'activeUsers' => 90, 'screenPageViews' => 450],
    ])));
});

test('the analytics page can be rendered', function () {
    Livewire::test(Analytics::class)
        ->assertSuccessful();
});

test('the analytics page is not accessible for guests', function () {
    auth()->logout();

    $this->get('/admin/analytics')
        ->assertRedirect('/admin/login');
});

test('the stats overview widget renders', function () {
    Livewire::test(AnalyticsOverviewStats::class)
        ->assertSuccessful();
});

test('the page views chart widget renders', function () {
    Livewire::test(PageViewsChart::class)
        ->assertSuccessful();
});

test('the popular posts table widget renders', function () {
    Livewire::test(PopularPostsTable::class)
        ->assertSuccessful();
});

test('the top referrers table widget renders', function () {
    Livewire::test(TopReferrersTable::class)
        ->assertSuccessful();
});

test('the top countries table widget renders', function () {
    Livewire::test(TopCountriesTable::class)
        ->assertSuccessful();
});

test('the analytics service returns overview stats', function () {
    $service = new AnalyticsService;
    $stats = $service->getOverviewStats(30);

    expect($stats)
        ->toHaveKeys(['totalPageViews', 'totalVisitors', 'avgDailyViews', 'totalPostsPublished', 'dailyPageViews', 'dailyVisitors'])
        ->and($stats['totalPageViews'])->toBe(950)
        ->and($stats['totalVisitors'])->toBe(190);
});

test('the analytics service counts published posts', function () {
    Post::factory()->count(3)->create([
        'published' => true,
        'publish_date' => now()->subDays(5),
    ]);

    Post::factory()->create([
        'published' => false,
    ]);

    cache()->flush();

    $service = new AnalyticsService;
    $stats = $service->getOverviewStats(30);

    expect($stats['totalPostsPublished'])->toBe(3);
});

test('the analytics service handles api errors gracefully', function () {
    AnalyticsFacade::swap(new class
    {
        public function __call($method, $args): never
        {
            throw new \RuntimeException('API error');
        }
    });

    cache()->flush();

    $service = new AnalyticsService;

    $stats = $service->getOverviewStats(30);
    expect($stats['totalPageViews'])->toBe(0);

    $daily = $service->getDailyVisitors(30);
    expect($daily)->toBeEmpty();

    $pages = $service->getMostVisitedPages(30);
    expect($pages)->toBeEmpty();

    $referrers = $service->getTopReferrers(30);
    expect($referrers)->toBeEmpty();

    $countries = $service->getTopCountries(30);
    expect($countries)->toBeEmpty();
});

test('the page views chart filter changes the data', function () {
    Livewire::test(PageViewsChart::class)
        ->assertSet('filter', '30')
        ->set('filter', '180')
        ->assertSet('filter', '180')
        ->assertSuccessful();
});

test('the popular posts table filter changes the data', function () {
    Livewire::test(PopularPostsTable::class)
        ->assertSet('days', '30')
        ->set('days', '180')
        ->assertSet('days', '180')
        ->assertSuccessful();
});

test('the analytics service matches pages to posts', function () {
    $post = Post::factory()->create([
        'title' => 'My Test Post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    AnalyticsFacade::swap(new FakeAnalytics(collect([
        ['pageTitle' => 'My Test Post', 'fullPageUrl' => "https://freek.dev/{$post->id}-my-test-post", 'screenPageViews' => 200],
        ['pageTitle' => 'Homepage', 'fullPageUrl' => 'https://freek.dev/', 'screenPageViews' => 500],
    ])));

    cache()->flush();

    $service = new AnalyticsService;
    $pages = $service->getMostVisitedPages(30);

    $postPage = $pages->first(fn (array $page) => $page['postId'] === $post->id);

    expect($postPage)->not->toBeNull()
        ->and($postPage['postTitle'])->toBe('My Test Post')
        ->and($postPage['pageViews'])->toBe(200);
});

test('the analytics service matches pages to posts when urls have no scheme', function () {
    $post = Post::factory()->create([
        'title' => 'My Test Post',
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    AnalyticsFacade::swap(new FakeAnalytics(collect([
        ['pageTitle' => 'My Test Post', 'fullPageUrl' => "freek.dev/{$post->id}-my-test-post", 'screenPageViews' => 200],
        ['pageTitle' => 'Homepage', 'fullPageUrl' => 'freek.dev/', 'screenPageViews' => 500],
    ])));

    cache()->flush();

    $service = new AnalyticsService;
    $pages = $service->getMostVisitedPages(30);

    $postPage = $pages->first(fn (array $page) => $page['postId'] === $post->id);

    expect($postPage)->not->toBeNull()
        ->and($postPage['postTitle'])->toBe('My Test Post')
        ->and($postPage['pageViews'])->toBe(200);
});
