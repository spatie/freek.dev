<?php

namespace App\Console\Commands;

use App\Services\Webmentions\ProcessWebhookJob;
use Illuminate\Console\Command;
use Spatie\WebhookClient\Models\WebhookCall;

class ProcessWebhookCommand extends Command
{
    protected $signature = 'blog:process-webhook {webhookCallId}';

    public function handle(): void
    {
        $webhookCall = WebhookCall::find($this->argument('webhookCallId'));

        if (! $webhookCall) {
            $this->error('No webhook call found with that id');

            return -1;
        }

        (new ProcessWebhookJob($webhookCall))->handle();

        $this->info('All done!');
    }
}
