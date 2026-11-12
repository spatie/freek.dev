<?php

use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Models\Post;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function () {
    $this->actingAs(User::factory()->create(['email' => 'freek@spatie.be', 'admin' => true]));
});

it('imports and creates a tweet through the editor without requiring a comment', function () {
    Http::fake(['publish.x.com/oembed*' => Http::response([
        'author_name' => 'Jack Sharkey',
        'html' => '<blockquote><p>Build APIs for agents.</p></blockquote>',
    ])]);

    Livewire::test(CreatePost::class)
        ->fillForm(['shared_tweet_url' => 'https://x.com/jsharkey/status/2107225649396281618'])
        ->callAction(TestAction::make('loadTweet')->schemaComponent('shared_tweet_url'))
        ->assertSchemaStateSet([
            'shared_tweet_author' => 'Jack Sharkey',
            'shared_tweet_text' => 'Build APIs for agents.',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Post::first())->shared_tweet_author->toBe('Jack Sharkey')->text->toBe('');
});

it('saves optional commentary and requires a snapshot for tweet posts', function () {
    Livewire::test(CreatePost::class)
        ->fillForm(['title' => 'A tweet', 'shared_tweet_url' => 'https://x.com/jsharkey/status/123'])
        ->call('create')->assertHasFormErrors(['shared_tweet_author', 'shared_tweet_text']);

    $post = Post::factory()->create([
        'shared_tweet_url' => 'https://x.com/jsharkey/status/123',
        'shared_tweet_author' => 'Jack Sharkey',
        'shared_tweet_text' => 'Build APIs for agents.',
    ]);

    Livewire::test(EditPost::class, ['record' => $post->id])
        ->fillForm(['text' => 'My **take**.'])
        ->call('save')->assertHasNoFormErrors();

    expect($post->fresh())->text->toBe('My **take**.')->shared_tweet_text->toBe('Build APIs for agents.');

    Livewire::test(EditPost::class, ['record' => $post->id])
        ->fillForm(['text' => null])
        ->call('save')->assertHasNoFormErrors();

    expect($post->fresh())->text->toBe('');
});

it('does not keep the previous snapshot when the tweet URL changes in the editor', function () {
    $post = Post::factory()->create([
        'shared_tweet_url' => 'https://x.com/jsharkey/status/123',
        'shared_tweet_author' => 'Jack Sharkey',
        'shared_tweet_text' => 'The previous tweet.',
    ]);

    Http::fake(['publish.x.com/oembed*' => Http::response([
        'author_name' => 'Sebastian De Deyne',
        'html' => '<blockquote><p>The replacement tweet.</p></blockquote>',
    ])]);

    Livewire::test(EditPost::class, ['record' => $post->id])
        ->fillForm(['shared_tweet_url' => 'https://x.com/sebdedeyne/status/456'])
        ->call('save')->assertHasFormErrors(['shared_tweet_author', 'shared_tweet_text'])
        ->callAction(TestAction::make('loadTweet')->schemaComponent('shared_tweet_url'))
        ->call('save')->assertHasNoFormErrors();

    expect($post->fresh())->shared_tweet_author->toBe('Sebastian De Deyne')
        ->shared_tweet_text->toBe('The replacement tweet.');
});
