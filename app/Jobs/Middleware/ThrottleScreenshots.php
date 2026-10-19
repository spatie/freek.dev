<?php

namespace App\Jobs\Middleware;

use Closure;
use Illuminate\Queue\Middleware\RateLimited;
use Spatie\LaravelScreenshot\Exceptions\CouldNotTakeScreenshot;

/**
 * All jobs that take screenshots share one rate limiter, because Cloudflare
 * Browser Run limits the number of screenshots per account (shared with
 * spatie.be). When Cloudflare still answers that a limit was hit, the job
 * is put back on the queue instead of failing.
 */
class ThrottleScreenshots
{
    public static string $rateLimiter = 'screenshots';

    public function handle(object $job, Closure $next): mixed
    {
        return (new RateLimited(self::$rateLimiter))->handle($job, function (object $job) use ($next) {
            try {
                return $next($job);
            } catch (CouldNotTakeScreenshot $exception) {
                $releaseAfterSeconds = $this->releaseAfterSeconds($exception);

                if ($releaseAfterSeconds === null) {
                    throw $exception;
                }

                $job->release($releaseAfterSeconds);

                return null;
            }
        });
    }

    protected function releaseAfterSeconds(CouldNotTakeScreenshot $exception): ?int
    {
        $message = strtolower($exception->getMessage());

        if (str_contains($message, 'time limit exceeded')) {
            return 60 * 60;
        }

        if (str_contains($message, 'rate limit exceeded')) {
            return 60;
        }

        if (str_contains($message, '"code":2001')) {
            return 60;
        }

        return null;
    }
}
