<?php

namespace Tests\Unit\Mails;

use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Tests\TestCase;

class LinkApprovedMailTest extends TestCase
{
    /** @test */
    public function the_link_approved_mail_can_be_rendered()
    {
        $link = Link::factory()->create();

        $this->assertIsString((new LinkApprovedMail($link))->render());
    }
}
