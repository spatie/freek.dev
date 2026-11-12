<?php

namespace App\Jobs;

use App\Jobs\Concerns\TakesScreenshots;
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
    use TakesScreenshots;

    public int $uniqueFor = 60 * 60 * 24;

    public function __construct(
        public string $hash,
        public string $format,
    ) {}

    public function uniqueId(): string
    {
        return "{$this->hash}.{$this->format}";
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
