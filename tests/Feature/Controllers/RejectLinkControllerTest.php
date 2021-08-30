<?php

use App\Models\Link;
use Tests\TestCase;

uses(TestCase::class);

it('can reject a link using a signed url', function () {
    /** @var \App\Models\Link $link */
    $link = Link::factory()->create([
        'status' => Link::STATUS_SUBMITTED,
    ]);

    $this->assertFalse($link->isRejected());

    $this->get($link->rejectUrl());

    $this->assertTrue($link->refresh()->isRejected());
});
