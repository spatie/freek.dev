<?php

use App\Mail\LinkApprovedMail;
use App\Models\Link;

test('the link approved mail can be rendered', function () {
    $link = Link::factory()->create();

    expect((new LinkApprovedMail($link))->render())->toBeString();
});

test('the link approved mail mentions our products and no coupon', function () {
    $link = Link::factory()->create();

    $rendered = (new LinkApprovedMail($link))->render();

    expect($rendered)
        ->toContain('Oh Dear')
        ->toContain('Flare')
        ->toContain('There There')
        ->toContain('Mailcoach')
        ->not->toContain('coupon');
});
