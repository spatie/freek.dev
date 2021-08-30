<?php

use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Tests\TestCase;

uses(TestCase::class);

it('can approve a link using a signed url', function () {
    Mail::fake();

    /** @var \App\Models\Link $link */
    $link = Link::factory()->create([
        'status' => Link::STATUS_SUBMITTED,
    ]);

    expect($link->isApproved())->toBeFalse();

    $this->get($link->approveUrl());

    expect($link->refresh()->isApproved())->toBeTrue();

    Mail::assertQueued(LinkApprovedMail::class);
});
