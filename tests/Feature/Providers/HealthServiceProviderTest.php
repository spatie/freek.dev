<?php

use App\Providers\HealthServiceProvider;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

/** @return array<int, string> */
function registerHealthChecks(): array
{
    Health::clearChecks();

    (new HealthServiceProvider(app()))->register();

    return collect(Health::registeredChecks())
        ->map(fn ($check) => $check::class)
        ->all();
}

afterEach(function () {
    unset($_ENV['LARAVEL_CLOUD']);
});

it('checks disk space when not running on laravel cloud', function () {
    expect(registerHealthChecks())->toContain(UsedDiskSpaceCheck::class);
});

it('skips the disk space check on laravel cloud', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';

    expect(registerHealthChecks())->not->toContain(UsedDiskSpaceCheck::class);
});
