<?php

use App\Jobs\GenerateOgImageForUrlJob;
use App\Jobs\GenerateOgImageJob;
use App\Jobs\Middleware\ThrottleScreenshots;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelScreenshot\Exceptions\CouldNotTakeScreenshot;

beforeEach(function () {
    Storage::fake('public');

    config()->set('laravel-screenshot.driver', 'cloudflare');
    config()->set('laravel-screenshot.cloudflare', ['api_token' => 'token', 'account_id' => 'account']);

    Http::preventStrayRequests();

    Cache::forever('og-image:abc123', ['url' => 'https://freek.dev/1234-my-post']);
});

function cloudflareError(int $code, string $message): array
{
    return ['success' => false, 'errors' => [['code' => $code, 'message' => $message]]];
}

function runThrottled(object $job): void
{
    (new ThrottleScreenshots)->handle($job, fn ($job) => app()->call([$job, 'handle']));
}

it('streams an og image that was already generated', function () {
    Storage::disk('public')->put('og-images/abc123.jpeg', 'jpeg-bytes');

    $this->get('og-image/abc123.jpeg')
        ->assertOk()
        ->assertHeader('Content-Type', 'image/jpeg')
        ->assertContent('jpeg-bytes');

    Bus::assertNothingDispatched();
});

it('queues a missing og image and redirects to the default og image meanwhile', function () {
    $this->get('og-image/abc123.jpeg')
        ->assertRedirect(url('images/og-image.jpg'))
        ->assertHeader('Cache-Control', 'no-store, private');

    Bus::assertDispatched(GenerateOgImageJob::class, fn (GenerateOgImageJob $job) => $job->hash === 'abc123' && $job->format === 'jpeg');
    Http::assertNothingSent();
});

it('queues a missing og image only once', function () {
    $this->get('og-image/abc123.jpeg');
    $this->get('og-image/abc123.jpeg');

    Bus::assertDispatchedTimes(GenerateOgImageJob::class, 1);
});

it('does not queue og images for unknown pages', function () {
    $this->get('og-image/def456.jpeg')->assertNotFound();

    Bus::assertNothingDispatched();
});

it('has a default og image to fall back to', function () {
    expect(public_path('images/og-image.jpg'))->toBeFile();
});

it('generates the og image on the queue', function () {
    Http::fake([
        'freek.dev/*' => Http::response('<html></html>'),
        'api.cloudflare.com/*' => Http::response('jpeg-bytes'),
    ]);

    app()->call([new GenerateOgImageJob('abc123', 'jpeg'), 'handle']);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.cloudflare.com/client/v4/accounts/account/browser-rendering/screenshot'
        && $request['url'] === 'https://freek.dev/1234-my-post?ogimage=');
    Storage::disk('public')->assertExists('og-images/abc123.jpeg');

    $this->get('og-image/abc123.jpeg')->assertOk()->assertContent('jpeg-bytes');
});

it('does not take a screenshot when the og image already exists', function () {
    Http::fake();
    Storage::disk('public')->put('og-images/abc123.jpeg', 'jpeg-bytes');

    app()->call([new GenerateOgImageJob('abc123', 'jpeg'), 'handle']);

    Http::assertNothingSent();
});

it('does not take a screenshot of a page that does not respond successfully', function () {
    Http::fake(['freek.dev/*' => Http::response('Not found', 404)]);

    app()->call([new GenerateOgImageJob('abc123', 'jpeg'), 'handle']);

    Http::assertNotSent(fn (Request $request) => str_contains($request->url(), 'api.cloudflare.com'));
    Storage::disk('public')->assertMissing('og-images/abc123.jpeg');
});

it('retries the og image later when cloudflare is rate limiting', function () {
    Http::fake([
        'freek.dev/*' => Http::response('<html></html>'),
        'api.cloudflare.com/*' => Http::response(cloudflareError(2001, 'Rate limit exceeded'), 429),
    ]);

    $job = (new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions();

    runThrottled($job);

    $job->assertReleased(delay: 60)->assertNotFailed();
    Storage::disk('public')->assertMissing('og-images/abc123.jpeg');
});

it('retries the og image an hour later when the daily browser time is used up', function () {
    Http::fake([
        'freek.dev/*' => Http::response('<html></html>'),
        'api.cloudflare.com/*' => Http::response(cloudflareError(2001, 'Browser time limit exceeded for today'), 429),
    ]);

    $job = (new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions();

    runThrottled($job);

    $job->assertReleased(delay: 60 * 60);
});

it('does not hide other screenshot errors', function () {
    Http::fake([
        'freek.dev/*' => Http::response('<html></html>'),
        'api.cloudflare.com/*' => Http::response(cloudflareError(10000, 'Authentication error'), 403),
    ]);

    runThrottled((new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions());
})->throws(CouldNotTakeScreenshot::class, 'Authentication error');

it('shares one screenshot rate limiter between all screenshot jobs', function () {
    Http::fake([
        'freek.dev/*' => Http::response('<html></html>'),
        'api.cloudflare.com/*' => Http::response('jpeg-bytes'),
    ]);

    runThrottled((new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions());

    $ogImageForUrlJob = (new GenerateOgImageForUrlJob('https://freek.dev/1234-my-post'))->withFakeQueueInteractions();

    runThrottled($ogImageForUrlJob);

    $ogImageForUrlJob->assertReleased();
    Http::assertSentCount(2);
});

it('does not throttle screenshots when not using cloudflare', function () {
    config()->set('laravel-screenshot.driver', 'browsershot');

    Storage::disk('public')->put('og-images/abc123.jpeg', 'jpeg-bytes');

    foreach (range(1, 3) as $attempt) {
        $job = (new GenerateOgImageJob('abc123', 'jpeg'))->withFakeQueueInteractions();

        runThrottled($job);

        $job->assertNotReleased();
    }
});

it('throttles all screenshot jobs', function (object $job) {
    expect($job->middleware())->toEqual([new ThrottleScreenshots])
        ->and($job->retryUntil())->toBeGreaterThan(now()->addHours(23));
})->with([
    fn () => new GenerateOgImageJob('abc123', 'jpeg'),
    fn () => new GenerateOgImageForUrlJob('https://freek.dev/1234-my-post'),
]);
