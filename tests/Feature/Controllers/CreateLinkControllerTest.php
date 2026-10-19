<?php

use App\Enums\LinkStatus;
use App\Mail\LinkSubmittedMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->actingAs($this->user);

    Mail::fake();
});

it('confirms link submission and only recommends active communities', function (): void {
    get(route('community.thanks'))
        ->assertOk()
        ->assertSeeText('Link submitted!')
        ->assertSee('href="https://laravel-news.com/links"', false)
        ->assertSee('href="https://news.ycombinator.com"', false)
        ->assertSee('href="https://reddit.com"', false)
        ->assertDontSee('aggregate.stitcher.io');
});

it('can create a link with all attributes', function () {
    $attributes = [
        'title' => 'my title',
        'url' => 'https://freek.dev',
        'text' => 'my text',
    ];

    Livewire::test('link-form')
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

    Livewire::test('link-form')
        ->set('form.title', $attributes['title'])
        ->set('form.url', $attributes['url'])
        ->set('form.text', $attributes['text'])
        ->call('save')
        ->assertRedirect('/community/thanks');

    Livewire::test('link-form')
        ->set('form.title', $attributes['title'])
        ->set('form.url', $attributes['url'])
        ->set('form.text', $attributes['text'])
        ->call('save')
        ->assertSee('The url has already been taken')
        ->assertNoRedirect();
});

it('can create a link without text', function () {
    Livewire::test('link-form')
        ->set('form.title', 'my title')
        ->set('form.url', 'https://example.com')
        ->call('save')
        ->assertRedirect('/community/thanks');
});
