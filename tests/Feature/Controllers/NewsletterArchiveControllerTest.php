<?php

use App\Models\NewsletterCampaign;
use Dom\HTMLDocument;

use function Pest\Laravel\get;

it('displays the newsletter archive listing', function () {
    $campaign = NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #100',
        'edition_number' => 100,
        'sent_at' => '2024-06-15',
    ]);

    get('/newsletter/archive')
        ->assertOk()
        ->assertSee('freek.dev newsletter #100')
        ->assertSee('#100')
        ->assertSee('2024')
        ->assertSee('Jun 15')
        ->assertSee('datetime="2024-06-15"', false)
        ->assertSee('href="'.$campaign->url.'"', false);
});

it('groups campaigns by year', function () {
    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #90',
        'sent_at' => '2023-03-15',
    ]);

    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #100',
        'sent_at' => '2024-06-15',
    ]);

    get('/newsletter/archive')
        ->assertOk()
        ->assertSee('2024')
        ->assertSee('2023')
        ->assertSee('freek.dev newsletter #100')
        ->assertSee('freek.dev newsletter #90');
});

it('displays a single newsletter campaign', function () {
    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #100',
        'slug' => 'freek-dev-newsletter-100',
        'web_view_html' => '<h1>Hello World</h1>',
        'sent_at' => '2024-06-15',
    ]);

    get('/newsletter/archive/freek-dev-newsletter-100')
        ->assertOk()
        ->assertSee('freek.dev newsletter #100')
        ->assertSee('Hello World');
});

it('returns 404 for a non-existing campaign', function () {
    get('/newsletter/archive/non-existing-slug')
        ->assertNotFound();
});

it('shows the subscription form on the archive listing', function () {
    $response = get('/newsletter/archive')
        ->assertOk()
        ->assertSee('Get the next one in your inbox')
        ->assertSee('Join 9,500+ smart developers')
        ->assertSee('Count me in');

    $document = HTMLDocument::createFromString($response->getContent(), LIBXML_NOERROR);
    $forms = $document->querySelectorAll('form[action="https://freek-dev.mailcoach.app/subscribe/590f564a-3f79-4981-8814-188fe39cc918"]');

    expect($forms)->toHaveCount(2);

    $emailIds = [];

    foreach ($forms as $form) {
        expect($form->getAttribute('method'))->toBe('post')
            ->and($form->querySelector('input[name="email"]')->hasAttribute('required'))->toBeTrue()
            ->and($form->querySelector('input[name="username"]'))->not->toBeNull();

        $emailIds[] = $form->querySelector('input[name="email"]')->getAttribute('id');
    }

    expect(array_unique($emailIds))->toHaveCount(2);
});

it('explains the empty archive while keeping signup available', function () {
    get('/newsletter/archive')
        ->assertOk()
        ->assertSee('Past editions will appear here.')
        ->assertSee('Get the next one in your inbox')
        ->assertDontSee('id="year-', false);
});

it('shows the subscription form on the detail page', function () {
    NewsletterCampaign::factory()->create([
        'slug' => 'freek-dev-newsletter-100',
    ]);

    get('/newsletter/archive/freek-dev-newsletter-100')
        ->assertOk()
        ->assertSee('Count me in');
});

it('shows the latest campaign on the newsletter page', function () {
    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #99',
        'web_view_html' => '<h1>Old newsletter</h1>',
        'sent_at' => '2024-01-15',
    ]);

    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #100',
        'web_view_html' => '<h1>Latest newsletter</h1>',
        'sent_at' => '2024-06-15',
    ]);

    get('/newsletter')
        ->assertOk()
        ->assertSee('latest edition')
        ->assertSee('freek.dev newsletter #100')
        ->assertSee('Latest newsletter')
        ->assertDontSee('Old newsletter');
});

it('shows the newsletter page without campaigns', function () {
    get('/newsletter')
        ->assertOk()
        ->assertDontSee('latest edition');
});

it('orders campaigns by sent_at descending', function () {
    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #99',
        'sent_at' => '2024-01-15',
    ]);

    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #100',
        'sent_at' => '2024-06-15',
    ]);

    get('/newsletter/archive')
        ->assertOk()
        ->assertSeeInOrder(['freek.dev newsletter #100', 'freek.dev newsletter #99']);
});
