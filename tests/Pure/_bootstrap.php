<?php

require __DIR__.'/../../vendor/autoload.php';

use Illuminate\Support\Facades\Bus;

/**
 * Shared setup for freek.dev's Pure tests: boot the real Laravel app, give each
 * worker its own already-migrated database, wrap every test in a rolled-back
 * transaction, and fake the bus (matching the project's Pest.php).
 */
function freekDevLaravel(): void
{
    \Pure\Laravel\useLaravel(
        basePath: dirname(__DIR__, 2),
        envResolver: fn (int $w) => [
            'APP_ENV' => 'testing',
            'BCRYPT_ROUNDS' => '4',
            'CACHE_STORE' => 'array',
            'SESSION_DRIVER' => 'array',
            'DB_DATABASE' => 'freekdev_test_test_'.($w + 1),
        ],
    );

    \Pure\beforeEach(fn () => Bus::fake());
}
