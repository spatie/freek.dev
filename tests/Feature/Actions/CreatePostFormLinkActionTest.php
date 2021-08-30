<?php

use App\Actions\CreatePostFromLinkAction;
use App\Models\Link;
use Tests\TestCase;

uses(TestCase::class);

it('can create a post from a link', function () {
    $link = Link::factory()->create();

    (new CreatePostFromLinkAction())->execute($link);

    $this->assertDatabaseHas('posts', [
        'submitted_by_user_id' => $link->user_id,
        'title' => $link->title,
        'text' => $link->text,
        'external_url' => $link->url,
        'published' => false,
    ]);
});
