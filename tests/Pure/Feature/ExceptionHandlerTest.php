<?php

use Illuminate\Contracts\Debug\ExceptionHandler;
use Livewire\Exceptions\PublicPropertyNotFoundException;

use function Pure\expect;
use function Pure\it;

it('does not report PublicPropertyNotFoundException', function () {
    $handler = app(ExceptionHandler::class);

    $exception = new PublicPropertyNotFoundException('data', 'Filament\Livewire\Topbar');

    expect($handler->shouldReport($exception))->toBeFalse();
});
