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

    $this->assertFalse($link->isApproved());

    $this->get($link->approveAndCreatePostUrl());

    $this->assertTrue($link->refresh()->isApproved());
    $this->assertDatabaseHas('posts', [
        'title' => $link->title,
    ]);
});
