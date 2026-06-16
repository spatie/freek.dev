<?php


use function Pure\expect;
use function Pure\it;
use function Pure\test;
use function Pure\beforeEach;
use function Pure\afterEach;
use App\Mail\LinkSubmittedMail;
use App\Models\Link;

test('the link approved mail can be rendered', function () {
    $link = Link::factory()->create();

    expect((new LinkSubmittedMail($link))->render())->toBeString();
});
