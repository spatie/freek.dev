<?php

namespace Tests\Feature\Actions;

use App\Actions\CreatePostFromLinkAction;
use App\Models\Link;
use Tests\TestCase;

class CreatePostFormLinkActionTest extends TestCase
{
    /** @test */
    public function it_can_create_a_post_from_a_link()
    {
        $link = factory(Link::class)->create();

        (new CreatePostFromLinkAction())->execute($link);

        $this->assertDatabaseHas('posts', [
            'submitted_by_user_id' => $link->user_id,
            'title' => $link->title,
            'text' => $link->text,
            'external_url' => $link->url,
            'published' => false,
        ]);
    }
}
