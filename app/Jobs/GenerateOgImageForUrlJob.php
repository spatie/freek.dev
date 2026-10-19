<?php

namespace App\Jobs;

use App\Jobs\Concerns\TakesScreenshots;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\OgImage\Facades\OgImage;

class GenerateOgImageForUrlJob implements ShouldQueue
{
    use Queueable;
    use TakesScreenshots;

    public function __construct(
        public string $url,
    ) {}

    public function handle(): void
    {
        OgImage::generateForUrl($this->url);
    }
}
