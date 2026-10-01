<?php

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schedule as ScheduleFacade;

/** @return array<int, string> */
function scheduledCommands(): array
{
    ScheduleFacade::swap(new Schedule);

    require base_path('routes/console.php');

    return collect(ScheduleFacade::events())
        ->map(fn (Event $event) => $event->command)
        ->all();
}

function scheduledEvent(string $command): Event
{
    ScheduleFacade::swap(new Schedule);

    require base_path('routes/console.php');

    return collect(ScheduleFacade::events())
        ->first(fn (Event $event) => str_contains((string) $event->command, $command));
}

afterEach(function () {
    unset($_ENV['LARAVEL_CLOUD'], $_ENV['ANALYTICS_SERVICE_ACCOUNT_CREDENTIALS']);
});

it('schedules backups when not running on laravel cloud', function () {
    expect(implode("\n", scheduledCommands()))
        ->toContain('backup:run')
        ->toContain('backup:clean');
});

it('crawls the site on a queue when not running on laravel cloud', function () {
    $crawlEvent = scheduledEvent('site-search:crawl');

    expect($crawlEvent->command)->not->toContain('--sync')
        ->and($crawlEvent->runInBackground)->toBeFalse()
        ->and($crawlEvent->expression)->toBe('0 2 * * *');
});

it('crawls the site inside the scheduler on laravel cloud', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';

    $crawlEvent = scheduledEvent('site-search:crawl');

    expect($crawlEvent->command)->toContain('--sync')
        ->and($crawlEvent->runInBackground)->toBeTrue();
});

it('does not schedule backups on laravel cloud', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';

    expect(implode("\n", scheduledCommands()))
        ->not->toContain('backup:run')
        ->not->toContain('backup:clean')
        ->toContain('site-search:crawl');
});

it('reads the analytics credentials from a file by default', function () {
    $config = require config_path('analytics.php');

    expect($config['service_account_credentials_json'])
        ->toBe(storage_path('app/analytics/service-account-credentials.json'));
});

it('can read the analytics credentials from an environment variable', function () {
    $_ENV['ANALYTICS_SERVICE_ACCOUNT_CREDENTIALS'] = base64_encode(json_encode(['type' => 'service_account']));

    $config = require config_path('analytics.php');

    expect($config['service_account_credentials_json'])->toBe(['type' => 'service_account']);
});
