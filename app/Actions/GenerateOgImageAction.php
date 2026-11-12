<?php

namespace App\Actions;

use App\Jobs\GenerateOgImageJob;
use Illuminate\Support\Facades\Storage;
use Spatie\OgImage\Actions\GenerateOgImageAction as BaseGenerateOgImageAction;
use Spatie\OgImage\OgImage;
use Symfony\Component\HttpFoundation\Response;

/**
 * Taking a screenshot is rate limited by Cloudflare Browser Run, so a missing
 * OG image is generated on the queue. Until it exists, visitors and crawlers
 * are sent to the default OG image instead of waiting for the screenshot.
 */
class GenerateOgImageAction extends BaseGenerateOgImageAction
{
    public function execute(string $filename): Response
    {
        $hash = pathinfo($filename, PATHINFO_FILENAME);
        $format = pathinfo($filename, PATHINFO_EXTENSION);

        if (! $hash || ! $format) {
            abort(404);
        }

        $ogImage = app(OgImage::class);
        $path = $ogImage->imagePath($hash, $format);
        $disk = Storage::disk(config('og-image.disk', 'public'));

        if ($disk->exists($path)) {
            return $this->serveImage($disk, $path, $format);
        }

        if (! $ogImage->getFromCache($hash)) {
            abort(404);
        }

        dispatch(new GenerateOgImageJob($hash, $format));

        return redirect(url('images/og-image.jpg'))->header('Cache-Control', 'no-store');
    }

    /*
     * Always stream the image, also from object storage, so og:image URLs never point to the storage backend.
     */
    protected function serveImage($disk, string $path, string $format): Response
    {
        return $this->respondWithImage($disk, $path, $format, config('og-image.redirect_cache_max_age', 60 * 60 * 24));
    }
}
