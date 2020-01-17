<?php

namespace Tests\Feature\Actions;

use App\Actions\RejectLinkAction;
use App\Models\Link;
use Tests\TestCase;

class RejectLinkActionTest extends TestCase
{
    /** @test */
    public function it_can_reject_a_link()
    {
        /** @var Link $submittedLink */
        $submittedLink = factory(Link::class)->create([
            'status' => Link::STATUS_SUBMITTED,
        ]);

        (new RejectLinkAction())->execute($submittedLink);

        $this->assertEquals(Link::STATUS_REJECTED, $submittedLink->status);
    }
}
