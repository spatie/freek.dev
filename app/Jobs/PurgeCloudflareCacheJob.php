<?php

namespace App\Jobs;

use App\Actions\PurgeEdgeCacheAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurgeCloudflareCacheJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(PurgeEdgeCacheAction $purgeEdgeCache): void
    {
        $purgeEdgeCache->execute();
    }
}
