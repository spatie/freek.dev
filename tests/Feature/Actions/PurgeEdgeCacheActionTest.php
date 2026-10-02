<?php

use App\Actions\PurgeEdgeCacheAction;
use App\Jobs\PurgeCloudflareCacheJob;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Sleep;

beforeEach(function () {
    Http::preventStrayRequests();

    Exceptions::fake();

    Sleep::fake();

    config([
        'services.laravel_cloud.purge_token' => 'cloud-token',
        'services.laravel_cloud.environment_id' => 'env-123',
        'services.cloudflare.zone_id' => null,
        'services.cloudflare.api_token' => 'cloudflare-token',
    ]);
});

it('purges everything on the laravel cloud edge', function () {
    Http::fake(['cloud.laravel.com/*' => Http::response(['data' => []])]);

    expect((new PurgeEdgeCacheAction)->execute())->toBeTrue();

    Http::assertSentCount(1);

    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->url() === 'https://cloud.laravel.com/api/environments/env-123/purge-edge-cache'
        && $request->hasHeader('Authorization', 'Bearer cloud-token')
        && $request->body() === '{}');
});

it('also purges the cloudflare zone when a zone id is configured', function () {
    config(['services.cloudflare.zone_id' => 'zone-456']);

    Http::fake([
        'cloud.laravel.com/*' => Http::response(['data' => []]),
        'api.cloudflare.com/*' => Http::response(['success' => true]),
    ]);

    expect((new PurgeEdgeCacheAction)->execute())->toBeTrue();

    Http::assertSentCount(2);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.cloudflare.com/client/v4/zones/zone-456/purge_cache'
        && $request->hasHeader('Authorization', 'Bearer cloudflare-token')
        && $request['purge_everything'] === true);
});

it('sends nothing when no edge cache is configured', function () {
    config([
        'services.laravel_cloud.purge_token' => null,
        'services.laravel_cloud.environment_id' => null,
    ]);

    Http::fake();

    $purgeEdgeCache = new PurgeEdgeCacheAction;

    expect($purgeEdgeCache->isConfigured())->toBeFalse()
        ->and($purgeEdgeCache->execute())->toBeTrue();

    Http::assertNothingSent();
});

it('does not purge laravel cloud without an environment id', function () {
    config(['services.laravel_cloud.environment_id' => null]);

    Http::fake();

    (new PurgeEdgeCacheAction)->execute();

    Http::assertNothingSent();
});

it('reports a failed purge without throwing', function () {
    Http::fake(['cloud.laravel.com/*' => Http::response(['message' => 'Forbidden'], 403)]);

    expect((new PurgeEdgeCacheAction)->execute())->toBeFalse();

    Http::assertSentCount(1);

    Exceptions::assertReported(RequestException::class);
});

it('retries a purge that fails with a server error', function () {
    Http::fake(['cloud.laravel.com/*' => Http::sequence()
        ->push(['message' => 'Oops'], 503)
        ->push(['data' => []]),
    ]);

    expect((new PurgeEdgeCacheAction)->execute())->toBeTrue();

    Http::assertSentCount(2);

    Exceptions::assertNothingReported();

    Sleep::assertSleptTimes(1);
});

it('does not fail the job when the purge fails', function () {
    Http::fake(['cloud.laravel.com/*' => Http::failedConnection()]);

    (new PurgeCloudflareCacheJob)->handle(new PurgeEdgeCacheAction);

    Http::assertSentCount(3);

    Exceptions::assertReported(ConnectionException::class);
});
