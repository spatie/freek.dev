<?php

namespace App\Mail;

use App\Models\Link;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LinkSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public ?Post $existingPost = null;

    public function __construct(
        public Link $link
    ) {
        $this->existingPost = Post::where('external_url', $this->link->url)->first();
    }

    public function build()
    {
        return $this->markdown('mails.links.submitted');
    }
}
