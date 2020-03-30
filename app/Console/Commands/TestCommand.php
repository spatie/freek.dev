<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\Artisan;

class TestCommand extends Command
{
    protected $signature = 'random';

    protected $description = 'Execute a random command';

    use ConfirmableTrait;

    public function handle()
    {
        $this->confirm('You are about to execute a random command. Are you sure you want to do this?');

        $allCommands = $this->getApplication()->all();

        $commandString = collect($allCommands)->keys()->random();

        $this->info("Executing command: `{$commandString}`");

        Artisan::call($commandString, [], $this->output);
    }
}
