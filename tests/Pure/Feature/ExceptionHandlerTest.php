<?php


use function Pure\expect;
use function Pure\it;
use function Pure\test;
use function Pure\beforeEach;
use function Pure\afterEach;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Livewire\Exceptions\PublicPropertyNotFoundException;

it('does not report PublicPropertyNotFoundException', function () {
    $handler = app(ExceptionHandler::class);

    $exception = new PublicPropertyNotFoundException('data', 'Filament\Livewire\Topbar');

    expect($handler->shouldReport($exception))->toBeFalse();
});
