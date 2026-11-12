<?php

use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();

    Exceptions::fake();

    config([
        'services.laravel_cloud.purge_token' => 'cloud-token',
        'services.laravel_cloud.environment_id' => 'env-123',
        'services.cloudflare.zone_id' => null,
    ]);
});

it('purges the edge cache', function () {
    Http::fake(['cloud.laravel.com/*' => Http::response(['data' => []])]);

    $this->artisan('cloudflare:purge-cache')
        ->expectsOutput('Edge cache purged.')
        ->assertSuccessful();
});

it('fails when the purge fails', function () {
    Http::fake(['cloud.laravel.com/*' => Http::response([], 403)]);

    $this->artisan('cloudflare:purge-cache')->assertFailed();
});

it('does nothing when no edge cache is configured', function () {
    config(['services.laravel_cloud.purge_token' => null]);

    Http::fake();

    $this->artisan('cloudflare:purge-cache')->assertSuccessful();

    Http::assertNothingSent();
});
