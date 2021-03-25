<?php

namespace App\Mail;

use App\Models\Post;
use Illuminate\Support\Collection;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;
use Spatie\Mailcoach\Domain\Campaign\Mails\WelcomeMail as MailcoachWelcomeMail;
use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;
use Spatie\Mailcoach\Domain\TransactionalMail\Mails\Concerns\StoresMail;
use Spatie\Mailcoach\Domain\TransactionalMail\Mails\Concerns\UsesMailcoachTemplate;

class WelcomeMail extends MailcoachWelcomeMail
{
    use StoresMail;
    use UsesMailcoachTemplate;

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
                ->template('welcome');
    }
}
