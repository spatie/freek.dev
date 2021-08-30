<?php

use Tests\Factories\PostFactory;
use Tests\TestCase;

it('can save the permalink of a tweet as the external url', function () {
    $tweetPost = (new PostFactory())->tweet()->create([
        'external_url' => null,
    ]);

    $this->artisan('blog:update-external-urls-with-tweet-permalinks');

    expect($tweetPost->refresh()->external_url)->toEqual('https://twitter.com/sebdedeyne/status/1130875746577264642?ref_src=twsrc%5Etfw');
});

it('will not overwrite existing external urls', function () {
    $tweetPost = (new PostFactory())->tweet()->create();

    $tweetPost->external_url = 'https://already-exists.com';
    $tweetPost->save();

    $this->artisan('blog:update-external-urls-with-tweet-permalinks');

    expect($tweetPost->refresh()->external_url)->toEqual('https://already-exists.com');
});
