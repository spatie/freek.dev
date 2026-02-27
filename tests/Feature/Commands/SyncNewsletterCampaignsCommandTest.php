<?php

use App\Models\NewsletterCampaign;
use Spatie\MailcoachSdk\Facades\Mailcoach;
use Spatie\MailcoachSdk\Resources\Campaign;
use Spatie\MailcoachSdk\Support\PaginatedResults;

use function Pest\Laravel\artisan;

function makeCampaignResource(array $attributes): Campaign
{
    $defaults = [
        'uuid' => fake()->uuid(),
        'name' => 'freek.dev newsletter #100',
        'status' => 'sent',
        'email_list_uuid' => null,
        'from_email' => null,
        'from_name' => null,
        'html' => null,
        'mailable_class' => null,
        'utm_tags' => false,
        'sent_to_number_of_subscribers' => 0,
        'segment_class' => null,
        'segment_description' => '',
        'open_count' => 0,
        'unique_open_count' => 0,
        'open_rate' => 0,
        'click_count' => 0,
        'unique_click_count' => 0,
        'click_rate' => 0,
        'unsubscribe_count' => 0,
        'unsubscribe_rate' => 0,
        'bounce_count' => 0,
        'bounce_rate' => 0,
        'sent_at' => '2024-06-15 10:00:00',
        'statistics_calculated_at' => null,
        'scheduled_at' => null,
        'last_modified_at' => null,
        'summary_mail_sent_at' => null,
        'created_at' => '2024-06-15 09:00:00',
        'updated_at' => '2024-06-15 10:00:00',
        'structured_html' => null,
        'email_html' => null,
        'webview_html' => null,
        'template_uuid' => null,
    ];

    return new Campaign(array_merge($defaults, $attributes), Mailcoach::getFacadeRoot());
}

function makePaginatedResults(array $campaigns, bool $hasNext = false): PaginatedResults
{
    return new PaginatedResults(
        $campaigns,
        ['first' => null, 'last' => null, 'prev' => null, 'next' => $hasNext ? 'campaigns?page=2' : null],
        ['current_page' => 1, 'total' => count($campaigns)],
        Mailcoach::getFacadeRoot(),
        Campaign::class,
    );
}

it('imports sent campaigns from Mailcoach', function () {
    $uuid = fake()->uuid();

    $campaign = makeCampaignResource([
        'uuid' => $uuid,
        'name' => 'freek.dev newsletter #100',
        'status' => 'sent',
        'sent_at' => '2024-06-15 10:00:00',
    ]);

    $fullCampaign = makeCampaignResource([
        'uuid' => $uuid,
        'name' => 'freek.dev newsletter #100',
        'webview_html' => '<h1>Newsletter content</h1>',
    ]);

    $mailcoach = Mockery::mock(Mailcoach::getFacadeRoot())->makePartial();
    $mailcoach->shouldReceive('campaigns')->once()->andReturn(makePaginatedResults([$campaign]));
    $mailcoach->shouldReceive('campaign')->with($uuid)->once()->andReturn($fullCampaign);
    Mailcoach::swap($mailcoach);

    artisan('newsletter:sync-campaigns')->assertSuccessful();

    expect(NewsletterCampaign::query()->count())->toBe(1);

    $imported = NewsletterCampaign::query()->first();
    expect($imported->mailcoach_uuid)->toBe($uuid);
    expect($imported->name)->toBe('freek.dev newsletter #100');
    expect($imported->edition_number)->toBe(100);
    expect($imported->slug)->toBe('freekdev-newsletter-100');
});

it('skips campaigns that do not match the naming pattern', function () {
    $campaign = makeCampaignResource([
        'name' => 'Some other campaign',
        'status' => 'sent',
    ]);

    $mailcoach = Mockery::mock(Mailcoach::getFacadeRoot())->makePartial();
    $mailcoach->shouldReceive('campaigns')->once()->andReturn(makePaginatedResults([$campaign]));
    $mailcoach->shouldNotReceive('campaign');
    Mailcoach::swap($mailcoach);

    artisan('newsletter:sync-campaigns')->assertSuccessful();

    expect(NewsletterCampaign::query()->count())->toBe(0);
});

it('skips campaigns that are not sent', function () {
    $campaign = makeCampaignResource([
        'name' => 'freek.dev newsletter #100',
        'status' => 'draft',
    ]);

    $mailcoach = Mockery::mock(Mailcoach::getFacadeRoot())->makePartial();
    $mailcoach->shouldReceive('campaigns')->once()->andReturn(makePaginatedResults([$campaign]));
    $mailcoach->shouldNotReceive('campaign');
    Mailcoach::swap($mailcoach);

    artisan('newsletter:sync-campaigns')->assertSuccessful();

    expect(NewsletterCampaign::query()->count())->toBe(0);
});

it('skips already imported campaigns', function () {
    $uuid = fake()->uuid();

    NewsletterCampaign::factory()->create([
        'mailcoach_uuid' => $uuid,
    ]);

    $campaign = makeCampaignResource([
        'uuid' => $uuid,
        'name' => 'freek.dev newsletter #100',
        'status' => 'sent',
    ]);

    $mailcoach = Mockery::mock(Mailcoach::getFacadeRoot())->makePartial();
    $mailcoach->shouldReceive('campaigns')->once()->andReturn(makePaginatedResults([$campaign]));
    $mailcoach->shouldNotReceive('campaign');
    Mailcoach::swap($mailcoach);

    artisan('newsletter:sync-campaigns')->assertSuccessful();

    expect(NewsletterCampaign::query()->count())->toBe(1);
});

it('extracts edition number correctly', function () {
    $uuid = fake()->uuid();

    $campaign = makeCampaignResource([
        'uuid' => $uuid,
        'name' => 'freek.dev newsletter #42',
        'status' => 'sent',
    ]);

    $fullCampaign = makeCampaignResource([
        'uuid' => $uuid,
        'webview_html' => '<p>Content</p>',
    ]);

    $mailcoach = Mockery::mock(Mailcoach::getFacadeRoot())->makePartial();
    $mailcoach->shouldReceive('campaigns')->once()->andReturn(makePaginatedResults([$campaign]));
    $mailcoach->shouldReceive('campaign')->with($uuid)->once()->andReturn($fullCampaign);
    Mailcoach::swap($mailcoach);

    artisan('newsletter:sync-campaigns')->assertSuccessful();

    expect(NewsletterCampaign::query()->first()->edition_number)->toBe(42);
});
