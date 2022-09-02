<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Mailcoach
{
    protected static function base(): PendingRequest
    {

        return Http::withToken(config('services.mailcoach.api_key'))
            ->acceptJson()
            ->baseUrl('https://freek-dev.mailcoach.app/api/');
    }

    public static function get(string $url): Response
    {
        return self::base()->get($url);
    }

    public static function post(string $url, array $payload = []): Response
    {
        return self::base()->post($url, $payload);
    }
}
