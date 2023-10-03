<?php

use App\Enums\LinkStatus;
use App\Models\Link;

use function Pest\Laravel\get;

it('can reject a link using a signed url', function () {
    /** @var \App\Models\Link $link */
    $link = Link::factory()->create([
        'status' => LinkStatus::Submitted->value,
    ]);

    expect($link->isRejected())->toBeFalse();

    get($link->rejectUrl())->assertSuccessful();

    expect($link->refresh()->isRejected())->toBeTrue();
});
