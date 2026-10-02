<?php

use App\Actions\PublishPostAction;
use App\Jobs\GenerateOgImageForUrlJob;
use App\Models\Post;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    Queue::fake();
});

it('sets publish_date to now when publishing a post without a date', function () {
    $post = Post::factory()->create([
        'published' => false,
        'publish_date' => null,
    ]);

    $this->freezeSecond();

    (new PublishPostAction)->execute($post);

    expect($post->refresh())
        ->published->toBeTrue()
        ->publish_date->toEqual(now());
});

it('overrides a future publish_date with now when publishing', function () {
    $futureDate = now()->addDays(10);

    $post = Post::factory()->create([
        'published' => false,
        'publish_date' => $futureDate,
    ]);

    $this->freezeSecond();

    (new PublishPostAction)->execute($post);

    expect($post->refresh())
        ->published->toBeTrue()
        ->publish_date->toEqual(now());
});

it('generates the og image of a published post on the throttled queue', function () {
    Bus::fake();

    $post = Post::factory()->create(['published' => false]);

    (new PublishPostAction)->execute($post);

    Bus::assertDispatched(GenerateOgImageForUrlJob::class, fn (GenerateOgImageForUrlJob $job) => $job->url === $post->url);
});
