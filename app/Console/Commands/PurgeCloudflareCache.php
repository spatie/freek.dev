<?php

namespace App\Console\Commands;

use App\Actions\PurgeEdgeCacheAction;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('cloudflare:purge-cache')]
#[Description('Purge the entire edge cache (Laravel Cloud and, if configured, the Cloudflare zone)')]
class PurgeCloudflareCache extends Command
{
    public function handle(PurgeEdgeCacheAction $purgeEdgeCache): int
    {
        if (! $purgeEdgeCache->isConfigured()) {
            $this->warn('No edge cache is configured, nothing to purge.');

            return self::SUCCESS;
        }

        if (! $purgeEdgeCache->execute()) {
            $this->error('Failed to purge the edge cache. The error has been reported.');

            return self::FAILURE;
        }

        $this->info('Edge cache purged.');

        return self::SUCCESS;
    }
}
