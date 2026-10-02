<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ServeObjectStorageAssetController
{
    /**
     * Fonts are loaded by the Hoefler stylesheet from freek.dev. Serving them from
     * the bucket's origin would require CORS, so they are always streamed.
     *
     * @var array<int, string>
     */
    protected array $alwaysStreamedSegments = ['fonts'];

    public function __invoke(string $segment, string $path): StreamedResponse|RedirectResponse
    {
        $diskName = config("filesystems.asset_url_segments.{$segment}");

        if (! $diskName) {
            abort(404);
        }

        if (str_contains($path, '..')) {
            abort(404);
        }

        $disk = Storage::disk($diskName);

        if ($this->shouldRedirectToBucket($segment)) {
            $encodedPath = collect(explode('/', $path))->map(rawurlencode(...))->implode('/');

            return redirect()->away($disk->url($encodedPath), 301, [
                'Cache-Control' => 'public, max-age=2592000',
            ]);
        }

        if (! $disk->fileExists($path)) {
            abort(404);
        }

        return $disk->response($path, headers: [
            'Cache-Control' => 'public, max-age=2592000',
        ]);
    }

    protected function shouldRedirectToBucket(string $segment): bool
    {
        if (! config('filesystems.object_storage_url')) {
            return false;
        }

        return ! in_array($segment, $this->alwaysStreamedSegments);
    }
}
