<?php


use function Pure\expect;
use function Pure\it;
use function Pure\test;
use function Pure\beforeEach;
use function Pure\afterEach;
use App\Enums\LinkStatus;
use App\Mail\LinkApprovedMail;
use App\Models\Link;

use function Pure\Laravel\get;

it('can approve a link using a signed url', function () {
    Mail::fake();

    /** @var Link $link */
    $link = Link::factory()->create([
        'status' => LinkStatus::Submitted->value,
    ]);

    expect($link->isApproved())->toBeFalse();

    get($link->approveUrl());

    expect($link->refresh()->isApproved())->toBeTrue();

    Mail::assertQueued(LinkApprovedMail::class);
});
