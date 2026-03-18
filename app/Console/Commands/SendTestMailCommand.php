<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('send-test-mail')]
class SendTestMailCommand extends Command
{
    public function handle(): void
    {
        Mail::to('someone-else@spatie.be')->send(new TestMail);

        $this->info('Test sent!');
    }
}
