<?php

use App\Actions\RejectLinkAction;
use App\Enums\LinkStatus;
use App\Models\Link;

use function Pure\expect;
use function Pure\it;

it('can reject a link', function () {
    /** @var Link $submittedLink */
    $submittedLink = Link::factory()->create([
        'status' => LinkStatus::Submitted,
    ]);

    (new RejectLinkAction)->execute($submittedLink);

    expect($submittedLink->status)->toEqual(LinkStatus::Rejected->value);
});
