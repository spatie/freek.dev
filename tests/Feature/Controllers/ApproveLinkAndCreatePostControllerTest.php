<?php

namespace Tests\Feature\Controllers;

use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Mail;
use Tests\TestCase;

class ApproveLinkAndCreatePostControllerTest extends TestCase
{
    /** @test */
    public function it_can_approve_a_link_and_create_a_post_using_a_signed_url()
    {
        Mail::fake();

        /** @var \App\Models\Link $link */
        $link = Link::factory()->create([
            'status' => Link::STATUS_SUBMITTED,
        ]);

        $this->assertFalse($link->isApproved());

        $this->get($link->approveAndCreatePostUrl());

        $this->assertTrue($link->refresh()->isApproved());
        $this->assertDatabaseHas('posts', [
            'title' => $link->title,
        ]);
    }
}
