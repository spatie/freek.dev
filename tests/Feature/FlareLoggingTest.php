<?php

use Illuminate\Support\Facades\Log;
use Monolog\Level;

it('has a log channel that sends logs to flare', function () {
    expect(config('logging.channels.flare.driver'))->toBe('flare');
});

it('sends info logs and above to flare', function () {
    expect(config('flare.minimal_log_level'))->toBe(Level::Info);
});

it('can log to a stack that includes the flare channel', function () {
    Log::stack(['single', 'flare'])->warning('A warning that is also sent to Flare');
})->throwsNoExceptions();
