<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Support\Collection;
use Spatie\Mailcoach\Mails\WelcomeMail as MailcoachWelcomeMail;
use Spatie\Mailcoach\Models\Subscriber;

class WelcomeMail extends MailcoachWelcomeMail
{
    /**
     * @var \App\Models\Post|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    private Collection $posts;

    public function __construct(Subscriber $subscriber)
    {
        parent::__construct($subscriber);

        $this->posts = Post::published()->originalContent()->orderByDesc('published_at')->limit(10)->get();
    }

    public function build()
    {
        return
            $this
                ->subject('Welcome to the freek.dev newsletter');
    }
}
