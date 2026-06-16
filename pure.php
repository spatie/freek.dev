<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Bus;

/**
 * Pure configuration for freek.dev. Auto-loaded by Pure before discovery, so
 * `pure` runs with no flags. The host autoloader is already loaded by Pure.
 */
Pure\testsIn('tests/Pure');

// Boot the real Laravel app and isolate every test in a rolled-back
// transaction. Each parallel worker gets its own already-migrated database.
Pure\Laravel\useLaravel(
    basePath: __DIR__,
    envResolver: fn (int $worker) => [
        'APP_ENV' => 'testing',
        'BCRYPT_ROUNDS' => '4',
        'CACHE_STORE' => 'array',
        'SESSION_DRIVER' => 'array',
        'DB_DATABASE' => 'freekdev_test_test_'.($worker + 1),
    ],
);

// Mirrors the project's Pest.php beforeEach.
Pure\beforeEach(fn () => Bus::fake());
