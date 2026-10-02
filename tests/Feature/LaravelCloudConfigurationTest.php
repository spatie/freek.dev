<?php

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;
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

it('backs up files and the database when not running on laravel cloud', function () {
    expect(scheduledEvent('backup:run')->command)->not->toContain('--only-db')
        ->and(implode("\n", scheduledCommands()))->not->toContain('app:backup-assets');
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

it('only backs up the database with laravel-backup on laravel cloud', function () {
    $_ENV['LARAVEL_CLOUD'] = '1';

    expect(scheduledEvent('backup:run')->command)->toContain('--only-db')
        ->and(implode("\n", scheduledCommands()))->toContain('backup:clean');
});

it('backs up assets when they are on object storage', function () {
    config()->set('filesystems.assets_on_object_storage', true);

    expect(implode("\n", scheduledCommands()))->toContain('app:backup-assets');
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

it('does not schedule anything every minute so laravel cloud can hibernate the app', function () {
    Artisan::call('schedule:list');

    expect(Artisan::output())->not->toMatch('/^\s*\*\s+\*\s+\*\s+\*\s+\*\s/m')
        ->and(scheduledEvent('health:check')->expression)->toBe('*/10 * * * *')
        ->and(scheduledEvent('blog:publish-scheduled-posts')->expression)->toBe('*/10 * * * *');
});
