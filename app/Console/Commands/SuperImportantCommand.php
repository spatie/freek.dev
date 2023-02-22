<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DummyCommand extends Command
{
    protected $signature = 'super-important';

    protected $description = 'Needs to run every day';

    public function handle()
    {
        /*
         * Add some very important code here
         */
    }
}
