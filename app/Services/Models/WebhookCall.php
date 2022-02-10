<?php

namespace App\Services\Models;

use Illuminate\Database\Eloquent\MassPrunable;
use Spatie\WebhookClient\Models\WebhookCall  as BaseWebhookCall;

class WebhookCall extends BaseWebhookCall
{
    use MassPrunable;

    public function prunable()
    {
        return static::where('created_at', '<=', now()->subDays(5));
    }
}
