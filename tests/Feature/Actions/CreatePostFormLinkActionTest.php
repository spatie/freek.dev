<?php

use App\Actions\CreatePostFromLinkAction;
use App\Models\Link;
use Spatie\TestTime\TestTime;

beforeEach(function () {
    TestTime::freeze('Y-m-d H:i:s', '2024-01-01 00:00:00');
});

it('can create a post from a link', function () {
    $link = Link::factory()->create();

    (new CreatePostFromLinkAction)->execute($link);

    $this->assertDatabaseHas('posts', [
        'submitted_by_user_id' => $link->user_id,
        'title' => $link->title,
        'text' => $link->text,
        'external_url' => $link->url,
        'published' => false,
        'publish_date' => '2024-01-01 14:00:00',
    ]);
});

it('will not publish a post on the same day', function () {
    $link = Link::factory()->create();
    (new CreatePostFromLinkAction)->execute($link);

    $this->assertDatabaseHas('posts', [
        'published' => false,
        'publish_date' => '2024-01-01 14:00:00',
    ]);

    $link = Link::factory()->create();
    (new CreatePostFromLinkAction)->execute($link);

    $this->assertDatabaseHas('posts', [
        'published' => false,
        'publish_date' => '2024-01-02 14:00:00',
    ]);
});
