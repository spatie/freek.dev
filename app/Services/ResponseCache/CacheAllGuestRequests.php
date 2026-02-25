<?php

namespace App\Services\ResponseCache;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;

class CacheAllGuestRequests extends CacheAllSuccessfulGetRequests
{
    public function shouldCacheRequest(Request $request): bool
    {
        if (auth()->check()) {
            return false;
        }

        if ($request->has(config('og-image.preview_parameter', 'ogimage'))) {
            return false;
        }

        return parent::shouldCacheRequest($request);
    }
}
