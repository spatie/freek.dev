<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

#[Signature('cloudflare:purge-cache')]
#[Description('Purge the entire Cloudflare cache')]
class PurgeCloudflareCache extends Command
{
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
