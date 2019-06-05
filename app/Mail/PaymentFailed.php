<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailed extends Mailable
{
    use Queueable, SerializesModels;

    /** @var string */
    public $email;

    /** @var int */
    public $amount;

    /** @var string  */
    public $exceptionMessage;

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
            ->view('mail.paymentFailed');
    }
}
