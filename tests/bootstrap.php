<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Bootstrap\HandleExceptions;

require_once __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap The Test Environment
|--------------------------------------------------------------------------
|
| You may specify console commands that execute once before your test is
| run. You are free to add your own additional commands or logic into
| this file as needed in order to help your test suite run quicker.
|
*/

$commands = [
    'event:cache',
];

$app = require __DIR__.'/../bootstrap/app.php';

$console = tap($app->make(Kernel::class))->bootstrap();

foreach ($commands as $command) {
    $console->call($command);
}

HandleExceptions::flushState();
