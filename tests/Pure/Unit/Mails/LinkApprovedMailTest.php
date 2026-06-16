<?php


use function Pure\expect;
use function Pure\it;
use function Pure\test;
use function Pure\beforeEach;
use function Pure\afterEach;
use App\Mail\LinkApprovedMail;
use App\Models\Link;

test('the link approved mail can be rendered', function () {
    $link = Link::factory()->create();

    expect((new LinkApprovedMail($link))->render())->toBeString();
});
