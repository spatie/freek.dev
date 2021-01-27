<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public int $amount,
        public string $exceptionMessage
    ) {
    }

    public function build()
    {
        return $this
            ->subject('Payment failed on freek.dev')
            ->view('mails.payments.paymentFailed');
    }
}
