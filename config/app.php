<?php

use Illuminate\Support\Facades\Facade;

return [
    'timezone' => 'Europe/Brussels',

    'log' => env('APP_LOG', 'single'),

    'log_level' => env('APP_LOG_LEVEL', 'debug'),

    'aliases' => Facade::defaultAliases()->merge([
        // ...
    ])->toArray(),

];
