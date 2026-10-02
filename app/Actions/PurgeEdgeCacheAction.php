<?php

namespace App\Actions;

use Closure;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

class PurgeEdgeCacheAction
{
    /**
     * Purges everything cached at the edge. Failures are reported instead of thrown,
     * so a failing purge never breaks publishing.
     */
    public function execute(): bool
    {
        $purgeResults = [];

        if ($this->laravelCloudIsConfigured()) {
            $purgeResults[] = $this->attempt(fn () => $this->purgeLaravelCloudEdge());
        }

        if ($this->cloudflareZoneIsConfigured()) {
            $purgeResults[] = $this->attempt(fn () => $this->purgeCloudflareZone());
        }

        return ! in_array(false, $purgeResults, true);
    }

    public function isConfigured(): bool
    {
        return $this->laravelCloudIsConfigured() || $this->cloudflareZoneIsConfigured();
    }

    protected function laravelCloudIsConfigured(): bool
    {
        return filled(config('services.laravel_cloud.purge_token'))
            && filled(config('services.laravel_cloud.environment_id'));
    }

    protected function cloudflareZoneIsConfigured(): bool
    {
        return filled(config('services.cloudflare.zone_id'))
            && filled(config('services.cloudflare.api_token'));
    }

    protected function purgeLaravelCloudEdge(): Response
    {
        $environmentId = config('services.laravel_cloud.environment_id');

        return $this->request(config('services.laravel_cloud.purge_token'))
            ->post("https://cloud.laravel.com/api/environments/{$environmentId}/purge-edge-cache", (object) []);
    }

    protected function purgeCloudflareZone(): Response
    {
        $zoneId = config('services.cloudflare.zone_id');

        return $this->request(config('services.cloudflare.api_token'))
            ->post("https://api.cloudflare.com/client/v4/zones/{$zoneId}/purge_cache", [
                'purge_everything' => true,
            ]);
    }

    protected function request(string $token): PendingRequest
    {
        return Http::withToken($token)
            ->acceptJson()
            ->timeout(10)
            ->retry(3, 1000, fn (Throwable $exception) => $this->isTransient($exception), throw: false);
    }

    protected function isTransient(Throwable $exception): bool
    {
        if ($exception instanceof ConnectionException) {
            return true;
        }

        if (! $exception instanceof RequestException) {
            return false;
        }

        return $exception->response->serverError() || $exception->response->tooManyRequests();
    }

    /** @param Closure(): Response $purge */
    protected function attempt(Closure $purge): bool
    {
        return rescue(function () use ($purge) {
            $purge()->throw();

            return true;
        }, false);
    }
}
