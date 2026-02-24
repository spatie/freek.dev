<?php

use App\Models\Post;
use Spatie\OgImage\Facades\OgImage;

it('generates OG images for published non-tweet posts and static pages', function () {
    OgImage::shouldReceive('generateForUrl')
        ->andReturnNull();

    Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    Post::factory()->create([
        'published' => false,
    ]);

    $tweetPost = Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDays(2),
    ]);
    $tweetPost->attachTag('tweet');

    $this->artisan('app:preheat-og-images')
        ->assertExitCode(0);

    // 11 static pages + 1 published non-tweet post = 12
    OgImage::shouldHaveReceived('generateForUrl')->times(12);
});

it('continues processing when a URL fails', function () {
    $callCount = 0;

    OgImage::shouldReceive('generateForUrl')
        ->andReturnUsing(function (string $url) use (&$callCount) {
            $callCount++;

            if ($callCount === 1) {
                throw new RuntimeException('Test failure');
            }

            return null;
        });

    Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    // 11 static + 1 post = 12 total; should not stop on the first failure
    $this->artisan('app:preheat-og-images')
        ->assertExitCode(0);

    OgImage::shouldHaveReceived('generateForUrl')->times(12);
});
