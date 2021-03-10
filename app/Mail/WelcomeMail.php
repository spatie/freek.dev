<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Support\Collection;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;
use Spatie\Mailcoach\Domain\Campaign\Mails\WelcomeMail as MailcoachWelcomeMail;
use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;

class WelcomeMail extends MailcoachWelcomeMail
{
    public Collection $posts;

    public Collection $campaigns;

    public function __construct(Subscriber $subscriber)
    {
        parent::__construct($subscriber);

        $this->campaigns = Campaign::sent()->orderByDesc('sent_at')->limit(3)->get();

        $this->posts = Post::published()->originalContent()->orderByDesc('publish_date')->limit(10)->get();
    }

    public function build()
    {
        return
            $this
                ->markdown('mails.welcome')
                ->subject('Welcome to the freek.dev newsletter');
    }
}
