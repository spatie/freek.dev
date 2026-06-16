<?php


use function Pure\expect;
use function Pure\it;
use function Pure\test;
use function Pure\beforeEach;
use function Pure\afterEach;
use App\Enums\LinkStatus;
use App\Models\Link;

use function Pure\Laravel\get;

it('can reject a link using a signed url', function () {
    /** @var Link $link */
    $link = Link::factory()->create([
        'status' => LinkStatus::Submitted->value,
    ]);

    expect($link->isRejected())->toBeFalse();

    get($link->rejectUrl())->assertSuccessful();

    expect($link->refresh()->isRejected())->toBeTrue();
});
