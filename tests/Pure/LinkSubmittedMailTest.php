<?php

use function Pure\expect;
use function Pure\it;
use function Pure\test;

use App\Mail\LinkSubmittedMail;
use App\Models\Link;

freekDevLaravel();

test('the link approved mail can be rendered', function () {
    $link = Link::factory()->create();

    expect((new LinkSubmittedMail($link))->render())->toBeString();
});
