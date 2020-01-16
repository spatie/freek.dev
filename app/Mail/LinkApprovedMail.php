<?php

namespace App\Mail;

use App\Models\Link;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LinkApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Link $link;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function build()
    {
        return $this->markdown('mails.links.approved');
    }
}
