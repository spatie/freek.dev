<?php

use App\Actions\ApproveLinkAction;
use App\Enums\LinkStatus;
use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();

    $this->approveLinkAction = app(ApproveLinkAction::class);
});

test('the action can approve a link', function () {
    /** @var Link $submittedLink */
    $submittedLink = Link::factory()->create([
        'status' => LinkStatus::Submitted->value,
    ]);

    $this->approveLinkAction->execute($submittedLink);

    expect($submittedLink->status)->toEqual(LinkStatus::Approved->value);

    Mail::assertQueued(LinkApprovedMail::class, fn (LinkApprovedMail $mail) => $mail->hasTo($submittedLink->user->email));
});

it('will not send a mail for a link that was already approved', function () {
    /** @var Link $submittedLink */
    $approvedLink = Link::factory()->create([
        'status' => LinkStatus::Approved->value,
    ]);

    $this->approveLinkAction->execute($approvedLink);

    Mail::assertNothingQueued();
});
