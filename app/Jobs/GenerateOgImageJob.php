<?php

namespace App\Jobs;

use App\Jobs\Middleware\ThrottleScreenshots;
use DateTimeInterface;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Uri;
use Spatie\OgImage\OgImage;
use Spatie\OgImage\OgImageGenerator;

class GenerateOgImageJob implements ShouldBeUnique, ShouldQueue
{
    use Queueable;

    public int $maxExceptions = 3;

    public int $uniqueFor = 60 * 60 * 24;

    public function __construct(
        public string $hash,
        public string $format,
    ) {}

    public function uniqueId(): string
    {
        return "{$this->hash}.{$this->format}";
    }

    /** @return array<int, object> */
    public function middleware(): array
    {
        return [new ThrottleScreenshots];
    }

    public function retryUntil(): DateTimeInterface
    {
        return now()->addDay();
    }

    /** @return array<int, int> */
    public function backoff(): array
    {
        return [60, 60 * 10, 60 * 60];
    }

    public function handle(OgImage $ogImage, OgImageGenerator $ogImageGenerator): void
    {
        $path = $ogImage->imagePath($this->hash, $this->format);

        if (Storage::disk(config('og-image.disk', 'public'))->exists($path)) {
            return;
        }

        $page = $ogImage->getFromCache($this->hash);

        if (! $page) {
            return;
        }

        $previewUrl = (string) Uri::of($page['url'])->withQuery([
            config('og-image.preview_parameter', 'ogimage') => '',
        ]);

        $response = Http::get($previewUrl);

        if (! $response->successful()) {
            Log::warning("Skipping OG image generation for non-successful response ({$response->status()}): {$page['url']}");

            return;
        }

        Log::info("Generating OG image: {$path} for {$page['url']}");

        $ogImageGenerator->generate($previewUrl, $path, $page['width'] ?? null, $page['height'] ?? null);
    }
}
