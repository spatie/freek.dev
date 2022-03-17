<?php

namespace App\Http\Controllers\Discovery;

class DebugController
{
    public function __invoke()
    {
        ray('Greetings from the server');

        return 'ok!';
    }
}
