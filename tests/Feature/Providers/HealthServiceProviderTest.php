<?php

use App\Providers\HealthServiceProvider;
use Spatie\Health\Checks\Checks\HorizonCheck;
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

it('checks horizon and disk space when running on a server with redis queues', function () {
    config()->set('queue.default', 'redis');

    expect(registerHealthChecks())
        ->toContain(HorizonCheck::class)
        ->toContain(UsedDiskSpaceCheck::class);
});

it('skips the horizon and disk space checks on laravel cloud', function () {
    config()->set('queue.default', 'cloud');
    $_ENV['LARAVEL_CLOUD'] = '1';

    expect(registerHealthChecks())
        ->not->toContain(HorizonCheck::class)
        ->not->toContain(UsedDiskSpaceCheck::class);
});
