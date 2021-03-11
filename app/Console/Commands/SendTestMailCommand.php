<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMailCommand extends Command
{
    protected $signature = 'send-test-mail';

    public function handle()
    {
        Mail::to('freek@spatie.be')->send(new TestMail());

        $this->info('Test sent!');
    }
}
