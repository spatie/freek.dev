<?php

use App\Mail\LinkSubmittedMail;
use App\Models\Link;
use Tests\TestCase;

uses(TestCase::class);

test('the link approved mail can be rendered', function () {
    $link = Link::factory()->create();

    expect((new LinkSubmittedMail($link))->render())->toBeString();
});
