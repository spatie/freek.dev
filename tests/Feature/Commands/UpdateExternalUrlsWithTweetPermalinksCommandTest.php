<?php

namespace Tests\Feature\Commands;

use Tests\Factories\PostFactory;
use Tests\TestCase;

class UpdateExternalUrlsWithTweetPermalinksCommandTest extends TestCase
{
    /** @test */
    public function it_can_save_the_permalink_of_a_tweet_as_the_external_url()
    {
        $tweetPost = (new PostFactory())->tweet()->create([
            'external_url' => null,
        ]);

        $this->artisan('blog:update-external-urls-with-tweet-permalinks');

        $this->assertEquals('https://twitter.com/sebdedeyne/status/1130875746577264642?ref_src=twsrc%5Etfw', $tweetPost->refresh()->external_url);
    }

    /** @test */
    public function it_will_not_overwrite_existing_external_urls()
    {
        $tweetPost = (new PostFactory())->tweet()->create();

        $tweetPost->external_url = 'https://already-exists.com';
        $tweetPost->save();

        $this->artisan('blog:update-external-urls-with-tweet-permalinks');

        $this->assertEquals('https://already-exists.com', $tweetPost->refresh()->external_url);
    }
}
