<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailed extends Mailable
{
    use Queueable, SerializesModels;

    public string $email;

    public int $amount;

    public string $exceptionMessage;

    public function __construct(string $email, int $amount, string $exceptionMessage)
    {
        $this->email = $email;

        $this->amount = $amount;

        $this->exceptionMessage = $exceptionMessage;
    }

    public function build()
    {
        return $this
            ->subject('Payment failed on freek.dev')
            ->view('mails.paymentFailed');
    }
}
