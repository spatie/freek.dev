<?php


namespace App\Services\Webmentions;

use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class WebmentionWebhookSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        if (! $request->has('secret')) {
            return false;
        }

        return $request->secret !== confg('services.webmentions.webhook_secret');
    }
}
