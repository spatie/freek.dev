<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;

    public int $amount;

    public function __construct(string $email, int $amount)
    {
        $this->email = $email;

        $this->amount = $amount;
    }

    public function build()
    {
        return $this
            ->subject('Payment made on freek.dev')
            ->view('mails.payments.paymentSuccessFul');
    }
}
