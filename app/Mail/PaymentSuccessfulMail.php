<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    public $email;

    /** @var int */
    public $amount;

    public function __construct(string $email, int $amount)
    {
        $this->email = $email;

        $this->amount = $amount;
    }

    public function build()
    {
        return $this
            ->subject('Payment made on murze.be')
            ->view('mail.paymentSuccessFul');
    }
}
