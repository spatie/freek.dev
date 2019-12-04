<?php

namespace Tests\Unit\Mails;

use App\Mail\WelcomeMail;
use Spatie\Mailcoach\Models\Subscriber;
use Tests\TestCase;

class WelcomeMailTest extends TestCase
{
    /** @test */
    public function the_welcome_mail_can_be_rendered()
    {
        $subscriber = factory(Subscriber::class)->create();

        $this->assertIsString((new WelcomeMail($subscriber))->render());
    }
}
