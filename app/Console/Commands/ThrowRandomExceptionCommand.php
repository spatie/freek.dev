<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class ThrowRandomExceptionCommand extends Command
{
    protected $signature = 'random-exception';

    public function handle()
    {
        throw new Exception('Random exception'.rand(1, 10000));
    }
}
