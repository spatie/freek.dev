<?php

use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Tests\TestCase;
use function \Pest\Laravel\get;

it('can approve a link using a signed url', function () {
    Mail::fake();

    /** @var \App\Models\Link $link */
    $link = Link::factory()->create([
        'status' => Link::STATUS_SUBMITTED,
    ]);

    expect($link->isApproved())->toBeFalse();

    get($link->approveUrl());

    expect($link->refresh()->isApproved())->toBeTrue();

    Mail::assertQueued(LinkApprovedMail::class);
});
