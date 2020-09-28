<?php

namespace App\Services\Models;

use Spatie\ModelCleanup\CleanupConfig;
use Spatie\ModelCleanup\GetsCleanedUp;
use Spatie\WebhookClient\Models\WebhookCall  as BaseWebhookCall;

class WebhookCall extends BaseWebhookCall implements GetsCleanedUp
{
    public function cleanUp(CleanupConfig $config): void
    {
        $config->olderThanDays(5);
    }
}
