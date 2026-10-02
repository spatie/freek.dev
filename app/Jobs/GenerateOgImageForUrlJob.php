<?php

namespace App\Jobs;

use App\Jobs\Middleware\ThrottleScreenshots;
use DateTimeInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\OgImage\Facades\OgImage;

class GenerateOgImageForUrlJob implements ShouldQueue
{
    use Queueable;

    public int $maxExceptions = 3;

    public function __construct(
        public string $url,
    ) {}

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

    public function handle(): void
    {
        OgImage::generateForUrl($this->url);
    }
}
