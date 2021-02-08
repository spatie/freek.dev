<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public int $amount
    ) {
    }

    public function build()
    {
        return $this
            ->subject('Payment made on freek.dev')
            ->view('mails.payments.paymentSuccessFul');
    }
}
