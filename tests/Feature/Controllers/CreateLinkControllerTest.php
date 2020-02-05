<?php

namespace Tests\Feature\Controllers;

use App\Http\Controllers\Links\CreateLinkController;
use App\Mail\LinkSumittedMail;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CreateLinkControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->actingAs($this->user);

        Mail::fake();
    }

    /** @test */
    public function it_can_create_a_link()
    {
        $attributes = [
            'title' => 'my title',
            'text' => 'my text',
            'url' => 'https://freek.dev',
        ];

        $this
            ->post(action([CreateLinkController::class, 'store'], $attributes))
            ->assertRedirect(route('links.thanks'));

        $expectedAttributes = array_merge([
            'user_id' => $this->user->id,
            'status' => Link::STATUS_SUBMITTED,
        ], $attributes);

        $this->assertDatabaseHas('links', $expectedAttributes);

        Mail::assertQueued(LinkSumittedMail::class);
    }

    /** @test */
    public function it_will_not_accept_a_link_that_was_already_submitted()
    {
        $this->withExceptionHandling();

        $attributes = [
            'title' => 'my title',
            'text' => 'my text',
            'url' => 'https://freek.dev',
        ];

        $this
            ->post(action([CreateLinkController::class, 'store'], $attributes))
            ->assertRedirect(route('links.thanks'));

        $this
            ->post(action([CreateLinkController::class, 'store'], $attributes))
            ->assertSessionHasErrors('url');
    }

    /** @test */
    public function it_can_create_a_link_without_text()
    {
        $attributes = [
            'title' => 'my title',
            'url' => 'https://freek.dev',
        ];

        $this
            ->post(action([CreateLinkController::class, 'store'], $attributes))
            ->assertRedirect(route('links.thanks'));
    }
}
