<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PurgeCloudflareCache extends Command
{
    protected $signature = 'cloudflare:purge-cache';

    protected $description = 'Purge the entire Cloudflare cache';

    public function handle(): int
    {
        $zoneId = config('services.cloudflare.zone_id');
        $apiToken = config('services.cloudflare.api_token');

        $response = Http::withToken($apiToken)
            ->post("https://api.cloudflare.com/client/v4/zones/{$zoneId}/purge_cache", [
                'purge_everything' => true,
            ]);

        if ($response->successful()) {
            $this->info('Cloudflare cache purged.');

            return self::SUCCESS;
        }

        $this->error('Failed to purge Cloudflare cache:');
        $this->error($response->body());

        return self::FAILURE;
    }
}
