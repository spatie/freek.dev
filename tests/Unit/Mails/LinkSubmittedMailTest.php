<?php

namespace Tests\Unit\Mails;

use App\Mail\LinkSumittedMail;
use App\Models\Link;
use Tests\TestCase;

class LinkSubmittedMailTest extends TestCase
{
    /** @test */
    public function the_link_approved_mail_can_be_rendered()
    {
        $link = factory(Link::class)->create();

        $this->assertIsString((new LinkSumittedMail($link))->render());
    }
}
