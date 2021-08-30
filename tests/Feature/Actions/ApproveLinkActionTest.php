<?php

use App\Actions\ApproveLinkAction;
use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

    Mail::fake();

    $this->approveLinkAction = app(ApproveLinkAction::class);
});

test('the action can approve a link', function () {
    /** @var Link $submittedLink */
    $submittedLink = Link::factory()->create([
        'status' => Link::STATUS_SUBMITTED,
    ]);

    $this->approveLinkAction->execute($submittedLink);

    $this->assertEquals(Link::STATUS_APPROVED, $submittedLink->status);

    Mail::assertQueued(LinkApprovedMail::class, fn (LinkApprovedMail $mail) => $mail->hasTo($submittedLink->user->email));
});

it('will not send a mail for a link that was already approved', function () {
    /** @var Link $submittedLink */
    $approvedLink = Link::factory()->create([
        'status' => Link::STATUS_APPROVED,
    ]);

    $this->approveLinkAction->execute($approvedLink);

    Mail::assertNothingQueued();
});
