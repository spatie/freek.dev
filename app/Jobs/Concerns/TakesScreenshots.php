<?php

namespace App\Jobs\Concerns;

use App\Jobs\Middleware\ThrottleScreenshots;
use DateTimeInterface;

trait TakesScreenshots
{
    public int $maxExceptions = 3;

    /** @return array<int, object> */
    public function middleware(): array
    {
        return [new ThrottleScreenshots];
    }

    public function retryUntil(): DateTimeInterface
    {
        return now()->addDay();
    }

    /** @return array<int, int> */
    public function backoff(): array
    {
        return [60, 60 * 10, 60 * 60];
    }
}
