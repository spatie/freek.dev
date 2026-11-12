<?php

use App\Models\MonitoredFeed;
use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    Sanctum::actingAs(User::factory()->admin()->create());

    $this->feedId = $this->callPostTool('save-monitored-feed', [
        'name' => 'Example source',
        'url' => 'https://example.com/feed.xml',
        'type' => 'blog',
        'baseline_before' => '2026-01-02T11:00:00+02:00',
    ])->assertJsonPath('result.isError', false)->json('result.structuredContent.feed.id');
});

it('upserts sources, preserves omitted fields and history when editing, and filters disabled podcasts', function () {
    $this->callPostTool('save-monitored-feed', ['url' => 'https://example.com/feed.xml', 'name' => 'Renamed'])
        ->assertJsonPath('result.structuredContent.feed.id', $this->feedId)
        ->assertJsonPath('result.structuredContent.feed.baseline_before', '2026-01-02T09:00:00.000000Z');

    $this->callPostTool('record-feed-check', ['feed_id' => $this->feedId, 'items' => [
        ['identifier' => 'old', 'url' => 'https://example.com/old'],
    ]])->assertJsonPath('result.isError', false);

    $this->callPostTool('save-monitored-feed', [
        'id' => $this->feedId, 'url' => 'https://example.com/corrected.xml', 'type' => 'podcast', 'enabled' => false,
    ])->assertJsonPath('result.structuredContent.feed.name', 'Renamed');

    $this->callPostTool('list-monitored-feeds', ['enabled' => true])->assertJsonCount(0, 'result.structuredContent.feeds');
    $this->callPostTool('list-monitored-feeds', ['type' => 'podcast', 'enabled' => false])
        ->assertJsonCount(1, 'result.structuredContent.feeds')
        ->assertJsonPath('result.structuredContent.feeds.0.seen_items_count', 1)
        ->assertJsonPath('result.structuredContent.feeds.0.url', 'https://example.com/corrected.xml');

    expect(MonitoredFeed::count())->toBe(1);
    expect(Post::count())->toBe(0);
});

it('suppresses historical backlog and deduplicates exact identities or URLs without moving the baseline', function () {
    $items = [
        ['identifier' => 'unrecorded-old', 'url' => 'https://example.com/old', 'published_at' => '2025-12-31T12:00:00+00:00'],
        ['identifier' => 'boundary', 'url' => 'https://example.com/boundary', 'published_at' => '2026-01-02T04:00:00-05:00'],
        ['identifier' => '/new/', 'url' => 'https://example.com/new', 'published_at' => '2026-01-02T09:00:01+00:00'],
        ['identifier' => 'changed-guid', 'url' => 'https://example.com/new', 'published_at' => '2026-01-03T09:00:00+00:00'],
        ['identifier' => '/new/', 'url' => 'https://example.com/changed-link', 'published_at' => '2026-01-03T09:00:00+00:00'],
        ['identifier' => '/NEW/', 'url' => 'https://example.com/case-sensitive', 'published_at' => null],
    ];

    $this->callPostTool('record-feed-check', ['feed_id' => $this->feedId, 'items' => $items])
        ->assertJsonPath('result.isError', false)
        ->assertJsonCount(2, 'result.structuredContent.new_items')
        ->assertJsonPath('result.structuredContent.new_items.0.identifier', '/new/')
        ->assertJsonPath('result.structuredContent.new_items.1.identifier', '/NEW/');

    $this->callPostTool('record-feed-check', ['feed_id' => $this->feedId, 'items' => $items])
        ->assertJsonCount(0, 'result.structuredContent.new_items');

    $this->callPostTool('list-seen-feed-items', ['feed_id' => $this->feedId, 'per_page' => 3, 'page' => 2])
        ->assertJsonPath('result.structuredContent.total', 4)
        ->assertJsonCount(1, 'result.structuredContent.items')
        ->assertJsonPath('result.structuredContent.items.0.identifier', 'unrecorded-old');

    $this->callPostTool('list-monitored-feeds')->assertJsonPath('result.structuredContent.feeds.0.baseline_before', '2026-01-02T09:00:00.000000Z');
});

it('isolates seen identities per source and silently seeds a recovered source', function () {
    $this->travelTo(now()->startOfSecond());
    $feedId = $this->callPostTool('save-monitored-feed', [
        'name' => 'Recovering source', 'url' => 'https://example.org/rss', 'type' => 'podcast',
    ])->json('result.structuredContent.feed.id');

    $this->callPostTool('record-feed-check', ['feed_id' => $feedId, 'error' => 'HTTP 404'])
        ->assertJsonPath('result.structuredContent.feed.baseline_before', null)
        ->assertJsonPath('result.structuredContent.feed.last_error', 'HTTP 404');

    $this->callPostTool('record-feed-check', ['feed_id' => $feedId, 'items' => []])
        ->assertJsonPath('result.isError', false)
        ->assertJsonPath('result.structuredContent.feed.baseline_before', null);

    $item = ['identifier' => 'same-guid', 'url' => 'https://example.com/episode', 'published_at' => now()->subDay()->toIso8601String()];

    $this->callPostTool('record-feed-check', ['feed_id' => $this->feedId, 'items' => [$item]])
        ->assertJsonCount(1, 'result.structuredContent.new_items');

    $this->callPostTool('record-feed-check', ['feed_id' => $feedId, 'items' => [$item]])
        ->assertJsonPath('result.structuredContent.initialized', true)
        ->assertJsonPath('result.structuredContent.feed.last_error', null)
        ->assertJsonCount(0, 'result.structuredContent.new_items');

    $this->callPostTool('record-feed-check', ['feed_id' => $feedId, 'error' => 'Timeout'])
        ->assertJsonPath('result.structuredContent.feed.last_error', 'Timeout');

    $this->travel(1)->minutes();
    $this->callPostTool('record-feed-check', ['feed_id' => $feedId, 'items' => [
        ['identifier' => 'next', 'url' => 'https://example.org/next', 'published_at' => now()->toIso8601String()],
    ]])->assertJsonCount(1, 'result.structuredContent.new_items');

    $this->callPostTool('list-seen-feed-items', ['feed_id' => $feedId])->assertJsonPath('result.structuredContent.total', 2);
});

it('rejects invalid edits and item batches without changing history', function () {
    foreach ([
        ['id' => $this->feedId, 'baseline_before' => '2026-01-01T00:00:00+00:00'],
        ['id' => $this->feedId, 'url' => 'file:///etc/passwd'],
        ['id' => $this->feedId, 'type' => 'other'],
    ] as $arguments) {
        $this->callPostTool('save-monitored-feed', $arguments)->assertJsonPath('result.isError', true);
    }

    foreach ([
        [],
        ['items' => [['identifier' => 'valid', 'url' => 'https://example.com/valid'], ['identifier' => 'invalid']]],
        ['items' => [['identifier' => 'id', 'url' => 'https://example.com/one', 'published_at' => '2026-01-01']]],
        ['items' => [['identifier' => 'id', 'url' => 'https://example.com/one']], 'error' => 'Failed'],
    ] as $arguments) {
        $this->callPostTool('record-feed-check', ['feed_id' => $this->feedId, ...$arguments])->assertJsonPath('result.isError', true);
    }

    $this->callPostTool('list-seen-feed-items', ['feed_id' => $this->feedId])->assertJsonPath('result.structuredContent.total', 0);
});

it('does not allow URL corrections to overwrite another source', function () {
    $otherId = $this->callPostTool('save-monitored-feed', [
        'name' => 'Other', 'url' => 'https://example.org/feed', 'type' => 'blog',
    ])->json('result.structuredContent.feed.id');

    $this->callPostTool('save-monitored-feed', ['id' => $this->feedId, 'url' => 'https://example.org/feed'])
        ->assertJsonPath('result.isError', true);

    $this->callPostTool('list-monitored-feeds')->assertJsonCount(2, 'result.structuredContent.feeds');
    expect($otherId)->not->toBe($this->feedId);
});

it('protects each monitoring tool from non-admins and anonymous callers', function (string $tool) {
    Sanctum::actingAs(User::factory()->create());
    $this->callPostTool($tool)->assertForbidden();

    auth()->forgetGuards();
    $this->callPostTool($tool)->assertUnauthorized();
})->with(['list-monitored-feeds', 'save-monitored-feed', 'list-seen-feed-items', 'record-feed-check']);

it('does not expose monitoring through public REST endpoints', function () {
    $this->getJson('/api/monitored-feeds')->assertNotFound();
    $this->getJson('/api/seen-feed-items')->assertNotFound();
});
