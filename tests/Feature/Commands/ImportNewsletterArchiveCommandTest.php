<?php

namespace Tests\Feature\Commands;

use App\Models\Newsletter;
use Tests\TestCase;

class ImportNewsletterArchiveCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        config()->set('services.sendy.archive_feed_url', __DIR__ . '/stubs/newsletterArchiveFeed.xml');
    }

    /** @test */
    public function it_can_import_the_newsletter_archive()
    {
        $this->artisan('blog:import-newsletter-archive')->assertExitCode(0);

        $this->assertCount(2, Newsletter::all());

        $firstNewsletter = Newsletter::first();

        $this->assertEquals(
            '👩‍🎓 freek.dev newsletter #88: webmentions, testing aggregates, Laravel Vapor on much more!',
            $firstNewsletter->title
        );

        $this->assertEquals(
            'https://sendy.freek.dev/w/CIlnrhEPa0CEBRUhZTotBQ',
            $firstNewsletter->url
        );

        $this->assertEquals('2019-07-29 03:00:01', $firstNewsletter->sent_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function it_will_not_import_newsletters_that_have_already_been_imported()
    {
        $this->artisan('blog:import-newsletter-archive')->assertExitCode(0);
        $this->assertCount(2, Newsletter::all());

        $this->artisan('blog:import-newsletter-archive')->assertExitCode(0);
        $this->assertCount(2, Newsletter::all());
    }
}
