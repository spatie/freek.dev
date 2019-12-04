<?php

namespace App\Mail;

use App\Models\Newsletter;
use App\Models\Post;
use Illuminate\Support\Collection;
use Spatie\Mailcoach\Mails\WelcomeMail as MailcoachWelcomeMail;
use Spatie\Mailcoach\Models\Subscriber;

class WelcomeMail extends MailcoachWelcomeMail
{
    public Collection $posts;

    public Collection $newsletters;

    public function __construct(Subscriber $subscriber)
    {
        parent::__construct($subscriber);

        $this->posts = Post::published()->originalContent()->orderByDesc('publish_date')->limit(10)->get();

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
