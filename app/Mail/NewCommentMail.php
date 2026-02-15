<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCommentMail extends Mailable
{
    use Queueable,
        SerializesModels;

    public function __construct(
        public Comment $comment,
        public Post $post,
    ) {}

    public function build(): self
    {
        return $this
            ->subject("New comment on: {$this->post->title}")
            ->markdown('mails.comments.new');
    }
}
