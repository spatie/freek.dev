<?php

namespace App\Http\Controllers\Discovery;

class DebugController
{
    public function __invoke()
    {
        ray('greetings from my server');

        return 'hallo nederland!';
    }
}
