<?php

namespace Tests\Feature\Controllers;

use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Mail;
use Tests\TestCase;

class RejectLinkControllerTest extends TestCase
{
    /** @test */
    public function it_can_reject_a_link_using_a_signed_url()
    {
        /** @var \App\Models\Link $link */
        $link = Link::factory()->create([
            'status' => Link::STATUS_SUBMITTED,
        ]);

        $this->assertFalse($link->isRejected());

        $this->get($link->rejectUrl());

        $this->assertTrue($link->refresh()->isRejected());
    }
}
