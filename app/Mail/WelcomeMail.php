<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Support\Collection;
use Spatie\Mailcoach\Mails\WelcomeMail as MailcoachWelcomeMail;
use Spatie\Mailcoach\Models\Subscriber;

class WelcomeMail extends MailcoachWelcomeMail
{
    private Collection $posts;

    private Collection $newsletters;

    public function __construct(Subscriber $subscriber)
    {
        parent::__construct($subscriber);

        $this->posts = Post::published()->originalContent()->orderByDesc('published_at')->limit(10)->get();

        $this->newsletters = Newsletter::orderByDesc('sent_at')->take(100)->get();
    }

    public function build()
    {
        return
            $this
                ->markdown('mail.welcome')
                ->subject('Welcome to the freek.dev newsletter');
    }
}
