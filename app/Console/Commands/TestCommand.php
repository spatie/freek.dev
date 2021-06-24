<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestCommand extends Command
{
    protected $signature = 'test';

    public function handle()
    {
        DB::table('unknown_table')
            ->where('non_existing_field', 'hey hey')
            ->get();
    }
}
