<?php

namespace App\Mail;

use App\Models\Link;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LinkSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Link $link
    ) {
    }

    public function build()
    {
        return $this->markdown('mails.links.submitted');
    }
}
