<?php

namespace Tests\Feature\Actions;

use App\Actions\ApproveLinkAction;
use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ApproveLinkActionTest extends TestCase
{
    private ApproveLinkAction $approveLinkAction;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->approveLinkAction = app(ApproveLinkAction::class);
    }

    /** @test */
    public function it_can_approve_a_link()
    {
        /** @var Link $submittedLink */
        $submittedLink = Link::factory()->create([
            'status' => Link::STATUS_SUBMITTED,
        ]);

        $this->approveLinkAction->execute($submittedLink);

        $this->assertEquals(Link::STATUS_APPROVED, $submittedLink->status);

        Mail::assertQueued(LinkApprovedMail::class, fn (LinkApprovedMail $mail) => $mail->hasTo($submittedLink->user->email));
    }

    /** @test */
    public function it_will_not_send_a_mail_for_a_link_that_was_already_approved()
    {
        /** @var Link $submittedLink */
        $approvedLink = Link::factory()->create([
            'status' => Link::STATUS_APPROVED,
        ]);

        $this->approveLinkAction->execute($approvedLink);

        Mail::assertNothingQueued();
    }
}
