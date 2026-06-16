<?php

use App\Enums\LinkStatus;
use App\Models\Link;
use Illuminate\Support\Facades\Mail;

use function Pure\expect;
use function Pure\it;
use function Pure\Laravel\assertDatabaseHas;
use function Pure\Laravel\get;

it('can approve a link and create a post using a signed url', function () {
    Mail::fake();

    /** @var Link $link */
    $link = Link::factory()->create([
        'status' => LinkStatus::Submitted->value,
    ]);

    expect($link->isApproved())->toBeFalse();

    get($link->approveAndCreatePostUrl());

    expect($link->refresh()->isApproved())->toBeTrue();
    assertDatabaseHas('posts', [
        'title' => $link->title,
    ]);
});
