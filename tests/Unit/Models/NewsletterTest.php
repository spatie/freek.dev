<?php

namespace Tests\Unit\Models;

use App\Models\Newsletter;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    /** @test */
    public function a_newsletter_is_tweetable()
    {
        $newsletter = factory(Newsletter::class)->create();

        $this->assertTrue(is_string($newsletter->toTweet()));
    }
}
