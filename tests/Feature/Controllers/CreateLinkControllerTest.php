<?php

use App\Http\Controllers\Discovery\Community\LinkController;
use App\Mail\LinkSubmittedMail;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

beforeEach(function () {
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

    post(action([LinkController::class, 'store'], $attributes))
        ->assertRedirect(route('community.thanks'));

    $this
        ->post(action([LinkController::class, 'store'], $attributes))
        ->assertSessionHasErrors('url');
});

it('can create a link without text', function () {
    $attributes = [
        'title' => 'my title',
        'url' => 'https://freek.dev',
    ];

    post(action([LinkController::class, 'store'], $attributes))
        ->assertRedirect(route('community.thanks'));
});

// Helpers
function it_can_create_a_link()
{
    $attributes = [
        'title' => 'my title',
        'text' => 'my text',
        'url' => 'https://freek.dev',
    ];

    post(action([LinkController::class, 'store'], $attributes))
        ->assertRedirect(route('community.thanks'));

    $expectedAttributes = array_merge([
        'user_id' => $this->user->id,
        'status' => Link::STATUS_SUBMITTED,
    ], $attributes);

    assertDatabaseHas('links', $expectedAttributes);

    Mail::assertQueued(LinkSubmittedMail::class);
}
