<?php

use App\Models\Link;
use Tests\TestCase;

uses(TestCase::class);

it('can approve a link and create a post using a signed url', function () {
    Mail::fake();

    /** @var \App\Models\Link $link */
    $link = Link::factory()->create([
        'status' => Link::STATUS_SUBMITTED,
    ]);

    expect($link->isApproved())->toBeFalse();

    $this->get($link->approveAndCreatePostUrl());

    expect($link->refresh()->isApproved())->toBeTrue();
    $this->assertDatabaseHas('posts', [
        'title' => $link->title,
    ]);
});
