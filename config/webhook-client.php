<?php

use App\Services\Webmentions\ProcessWebhookJob;
use App\Services\Webmentions\WebmentionWebhookSignatureValidator;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile;

return [
    'configs' => [
        [
            /*
             * This package support multiple webhook receiving endpoints. If you only have
             * one endpoint receiving webhooks, you can use 'default'.
             */
            'name' => 'webmentions',

            /*
             *  This class will verify that the content of the signature header is valid.
             *
             * It should implement \Spatie\WebhookClient\SignatureValidator\SignatureValidator
             */
            'signature_validator' => WebmentionWebhookSignatureValidator::class,

            /*
             * This class determines if the webhook call should be stored and processed.
             */
            'webhook_profile' => ProcessEverythingWebhookProfile::class,

            /*
             * The classname of the model to be used to store call. The class should be equal
             * or extend Spatie\WebhookClient\Models\WebhookCall.
             */
            'webhook_model' => WebhookCall::class,

            /*
             * The class name of the job that will process the webhook request.
             *
             * This should be set to a class that extends \Spatie\WebhookClient\ProcessWebhookJob.
             */
            'process_webhook_job' => ProcessWebhookJob::class,
        ],
    ],
];
