<?php

use App\Models\NewsletterCampaign;

use function Pest\Laravel\get;

it('displays the newsletter archive listing', function () {
    NewsletterCampaign::factory()->create([
        'name' => 'freek.dev newsletter #100',
        'sent_at' => '2024-06-15',
    ]);

    get('/newsletter/archive')
        ->assertOk()
        ->assertSee('freek.dev newsletter #100')
        ->assertSee('2024');
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
    get('/newsletter/archive')
        ->assertOk()
        ->assertSee('Count me in');
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
        ->assertSee('Latest edition')
        ->assertSee('freek.dev newsletter #100')
        ->assertSee('Latest newsletter')
        ->assertDontSee('Old newsletter');
});

it('shows the newsletter page without campaigns', function () {
    get('/newsletter')
        ->assertOk()
        ->assertDontSee('Latest edition');
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
