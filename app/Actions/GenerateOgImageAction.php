<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\OgImage\Actions\GenerateOgImageAction as BaseGenerateOgImageAction;

class GenerateOgImageAction extends BaseGenerateOgImageAction
{
    protected function generateImage(array $cached, string $path, $disk): void
    {
        $pageUrl = $cached['url'];
        $previewParameter = config('og-image.preview_parameter', 'ogimage');
        $separator = str_contains($pageUrl, '?') ? '&' : '?';
        $screenshotUrl = $pageUrl.$separator.$previewParameter;

        $response = Http::get($screenshotUrl);

        if (! $response->successful()) {
            Log::warning("Skipping OG image generation for non-successful response ({$response->status()}): {$pageUrl}");

            abort(404);
        }

        Log::info("Generating OG image: {$path} for {$pageUrl}");

        parent::generateImage($cached, $path, $disk);
    }
}
