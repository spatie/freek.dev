<?php

use App\Http\Controllers\Links\CreateLinkController;
use App\Mail\LinkSubmittedMail;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    parent::setUp();

    $this->user = User::factory()->create();

    $this->actingAs($this->user);

    Mail::fake();
});

it('will not accept a link that was already submitted', function () {
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
});

it('can create a link without text', function () {
    $attributes = [
        'title' => 'my title',
        'url' => 'https://freek.dev',
    ];

    $this
        ->post(action([CreateLinkController::class, 'store'], $attributes))
        ->assertRedirect(route('links.thanks'));
});

// Helpers
function it_can_create_a_link()
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

    Mail::assertQueued(LinkSubmittedMail::class);
}
