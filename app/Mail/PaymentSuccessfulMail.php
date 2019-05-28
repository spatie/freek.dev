<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
            ->subject('Payment made on freek.dev')
            ->view('mail.paymentSuccessFul');
    }
}
