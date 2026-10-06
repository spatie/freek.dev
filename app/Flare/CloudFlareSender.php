<?php

namespace App\Flare;

use Closure;
use Spatie\FlareClient\Enums\FlareEntityType;
use Spatie\FlareClient\Senders\DaemonSender;
use Spatie\FlareClient\Senders\Sender;
use Spatie\LaravelFlare\Senders\LaravelHttpSender;

class CloudFlareSender implements Sender
{
    protected Sender $sender;

    public function __construct(array $config = [])
    {
        $isQueueWorker = PHP_SAPI === 'cli'
            && in_array($_SERVER['argv'][1] ?? null, [
                'queue:work',
                'queue:listen',
                'horizon',
                'horizon:work',
            ], true);

        $this->sender = $isQueueWorker
            ? new LaravelHttpSender(['timeout' => 10])
            : new DaemonSender($config);
    }

    public function post(
        string $endpoint,
        string $apiToken,
        array $payload,
        FlareEntityType $type,
        bool $test,
        Closure $callback,
    ): void {
        $this->sender->post($endpoint, $apiToken, $payload, $type, $test, $callback);
    }
}
