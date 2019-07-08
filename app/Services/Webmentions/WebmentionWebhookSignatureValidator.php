<?php


namespace App\Services\Webmentions;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class WebmentionWebhookSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        \Log::info(print_r($request->all, true));

        return true;
        if (! $request->has('secret')) {
            return false;
        }

        return $request->secret !== config('services.webmentions.webhook_secret');
    }
}
