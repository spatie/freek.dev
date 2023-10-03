<?php

use App\Enums\LinkStatus;
use App\Mail\LinkSubmittedMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Volt\Volt;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);

    Mail::fake();
});

it('can create a link with all attributes', function () {
    $attributes = [
        'title' => 'my title',
        'url' => 'https://freek.dev',
        'text' => 'my text',
    ];

    Volt::test('linkForm')
        ->set('form.title', $attributes['title'])
        ->set('form.url', $attributes['url'])
        ->set('form.text', $attributes['text'])
        ->call('save')
        ->assertRedirect('/community/thanks');

    $expectedAttributes = array_merge([
        'user_id' => $this->user->id,
        'status' => LinkStatus::Submitted->value,
    ], $attributes);

    assertDatabaseHas('links', $expectedAttributes);

    Mail::assertQueued(LinkSubmittedMail::class);
});

it('will not accept a link that was already submitted', function () {
    $attributes = [
        'title' => 'my title',
        'text' => 'my text',
        'url' => 'https://freek.dev',
    ];

    Volt::test('linkForm')
        ->set('form.title', $attributes['title'])
        ->set('form.url', $attributes['url'])
        ->set('form.text', $attributes['text'])
        ->call('save')
        ->assertRedirect('/community/thanks');

    Volt::test('linkForm')
        ->set('form.title', $attributes['title'])
        ->set('form.url', $attributes['url'])
        ->set('form.text', $attributes['text'])
        ->call('save')
        ->assertSee('The url has already been taken')
        ->assertNoRedirect();
});

it('can create a link without text', function () {
    Volt::test('linkForm')
        ->set('form.title', 'my title')
        ->set('form.url', 'https://example.com')
        ->call('save')
        ->assertRedirect('/community/thanks');
});
