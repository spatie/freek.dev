<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ServeObjectStorageAssetController
{
    public function __invoke(string $segment, string $path): StreamedResponse
    {
        $diskName = config("filesystems.asset_url_segments.{$segment}");

        if (! $diskName) {
            abort(404);
        }

        $disk = Storage::disk($diskName);

        if (str_contains($path, '..')) {
            abort(404);
        }

        if (! $disk->exists($path)) {
            abort(404);
        }

        return $disk->response($path, headers: [
            'Cache-Control' => 'public, max-age=2592000',
        ]);
    }
}
