<?php

use App\Actions\RejectLinkAction;
use App\Models\Link;
use Tests\TestCase;

uses(TestCase::class);

it('can reject a link', function () {
    /** @var Link $submittedLink */
    $submittedLink = Link::factory()->create([
        'status' => Link::STATUS_SUBMITTED,
    ]);

    (new RejectLinkAction())->execute($submittedLink);

    expect($submittedLink->status)->toEqual(Link::STATUS_REJECTED);
});
