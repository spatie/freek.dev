<?php

use App\Models\Link;
use Tests\TestCase;
use function Pest\Laravel\get;

it('can reject a link using a signed url', function () {
    /** @var \App\Models\Link $link */
    $link = Link::factory()->create([
        'status' => Link::STATUS_SUBMITTED,
    ]);

    expect($link->isRejected())->toBeFalse();

    get($link->rejectUrl());

    expect($link->refresh()->isRejected())->toBeTrue();
});
