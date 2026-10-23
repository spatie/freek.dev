<?php

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\ResponseCache\Facades\ResponseCache;

it('can store binary values in the database cache', function () {
    $binaryValue = "\xD2\x01\x0Av\x0At";

    Cache::store('database')->put('binary-value', $binaryValue);

    expect(Cache::store('database')->get('binary-value'))->toBe($binaryValue);
});

it('clears cloud response cache without resetting runtime coordination or OG image metadata', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';
    $_ENV['RESPONSE_CACHE_DRIVER'] = 'database';
    $lock = null;

    try {
        config()->set('responsecache', require config_path('responsecache.php'));
        config()->set('responsecache.enabled', true);
        config()->set('cache.default', 'database');

        $cache = Cache::store('database');
        $rateLimiter = new RateLimiter($cache);
        $lock = $cache->lock('laravel_unique_job:cache-isolation', 60);
        $request = Request::create('https://freek.dev/cache-isolation');

        $cache->forever('og-image:cache-isolation', ['url' => 'https://freek.dev/example']);
        $rateLimiter->hit('testimonial-submission:cache-isolation', 3600);
        expect($lock->get())->toBeTrue();

        ResponseCache::cacheResponse($request, response('Cached page'), 60);
        expect(ResponseCache::hasBeenCached($request))->toBeTrue();

        $this->artisan('responsecache:clear')->assertSuccessful();

        expect(ResponseCache::hasBeenCached($request))->toBeFalse()
            ->and($cache->get('og-image:cache-isolation'))->toBe(['url' => 'https://freek.dev/example'])
            ->and($rateLimiter->tooManyAttempts('testimonial-submission:cache-isolation', 1))->toBeTrue()
            ->and($cache->lock('laravel_unique_job:cache-isolation', 60)->get())->toBeFalse();
    } finally {
        $lock?->release();
        unset($_ENV['LARAVEL_CLOUD'], $_ENV['RESPONSE_CACHE_DRIVER']);
    }
});
