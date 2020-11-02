<?php

namespace Tests\Feature\Controllers;

use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Mail;
use Tests\TestCase;

class ApproveLinkControllerTest extends TestCase
{
    /** @test */
    public function it_can_approve_a_link_using_a_signed_url()
    {
        Mail::fake();

        /** @var \App\Models\Link $link */
        $link = Link::factory()->create([
            'status' => Link::STATUS_SUBMITTED,
        ]);

        $this->assertFalse($link->isApproved());

        $this->get($link->approveUrl());

        $this->assertTrue($link->refresh()->isApproved());

        Mail::assertQueued(LinkApprovedMail::class);
    }
}
