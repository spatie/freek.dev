<?php

use App\Livewire\TestimonialForm;
use App\Mail\TestimonialSubmittedMail;
use App\Models\NewsletterTestimonial;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;

it('shows a testimonial in the newsletter block on a blog post', function () {
    $testimonial = NewsletterTestimonial::factory()->create([
        'text' => 'This newsletter is amazing!',
        'author_name' => 'Jane Doe',
        'is_active' => true,
    ]);

    $post = \App\Models\Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $this->get($post->url)
        ->assertOk()
        ->assertSee('This newsletter is amazing!')
        ->assertSee('Jane Doe');
});

it('does not show inactive testimonials', function () {
    NewsletterTestimonial::factory()->create([
        'text' => 'Hidden testimonial',
        'is_active' => false,
    ]);

    $post = \App\Models\Post::factory()->create([
        'published' => true,
        'publish_date' => now()->subDay(),
    ]);

    $this->get($post->url)
        ->assertOk()
        ->assertDontSee('Hidden testimonial');
});

it('shows all testimonials on the newsletter page', function () {
    NewsletterTestimonial::factory()->create([
        'text' => 'First testimonial',
        'is_active' => true,
    ]);

    NewsletterTestimonial::factory()->create([
        'text' => 'Second testimonial',
        'is_active' => true,
    ]);

    $this->get('/newsletter')
        ->assertOk()
        ->assertSee('First testimonial')
        ->assertSee('Second testimonial');
})->skip('Testimonial ticker temporarily commented out');

it('does not show the newsletter form in the homepage sidebar', function () {
    $this->get('/')
        ->assertOk()
        ->assertDontSee('Monthly tips on Laravel, PHP, and AI');
});

it('can view the testimonial submission form', function () {
    $this->get('/newsletter/testimonial')
        ->assertOk()
        ->assertSee('Recommend this newsletter');
});

it('can submit a testimonial', function () {
    Mail::fake();
    RateLimiter::clear('testimonial-submission:127.0.0.1');

    Livewire::test(TestimonialForm::class)
        ->set('form.text', 'Great newsletter!')
        ->set('form.author_name', 'John Doe')
        ->set('form.author_title', 'Developer')
        ->set('form.author_url', 'https://example.com')
        ->call('save')
        ->assertRedirect('/newsletter/testimonial/thanks');

    $testimonial = NewsletterTestimonial::latest()->first();

    expect($testimonial)
        ->text->toBe('Great newsletter!')
        ->author_name->toBe('John Doe')
        ->author_title->toBe('Developer')
        ->author_url->toBe('https://example.com')
        ->is_active->toBeFalse();

    Mail::assertQueued(TestimonialSubmittedMail::class);
});

it('can submit a testimonial with an avatar', function () {
    Mail::fake();
    RateLimiter::clear('testimonial-submission:127.0.0.1');

    Livewire::test(TestimonialForm::class)
        ->set('form.text', 'Love this newsletter!')
        ->set('form.author_name', 'Jane Doe')
        ->set('form.avatar', UploadedFile::fake()->image('avatar.jpg'))
        ->call('save')
        ->assertRedirect('/newsletter/testimonial/thanks');

    $testimonial = NewsletterTestimonial::latest()->first();

    expect($testimonial)
        ->getMedia('avatar')->toHaveCount(1)
        ->avatar_url->not->toBeEmpty();
});

it('validates required fields when submitting a testimonial', function () {
    Livewire::test(TestimonialForm::class)
        ->set('form.text', '')
        ->set('form.author_name', '')
        ->call('save')
        ->assertHasErrors(['form.text', 'form.author_name']);
});

it('validates url fields when submitting a testimonial', function () {
    Livewire::test(TestimonialForm::class)
        ->set('form.text', 'Great newsletter!')
        ->set('form.author_name', 'John Doe')
        ->set('form.author_url', 'not-a-url')
        ->call('save')
        ->assertHasErrors(['form.author_url']);
});

it('validates avatar must be an image', function () {
    Livewire::test(TestimonialForm::class)
        ->set('form.text', 'Great newsletter!')
        ->set('form.author_name', 'John Doe')
        ->set('form.avatar', UploadedFile::fake()->create('document.pdf', 100))
        ->call('save')
        ->assertHasErrors(['form.avatar']);
});

it('rate limits testimonial submissions', function () {
    Mail::fake();

    for ($i = 0; $i < 15; $i++) {
        RateLimiter::hit('testimonial-submission:127.0.0.1', 3600);
    }

    Livewire::test(TestimonialForm::class)
        ->set('form.text', 'Great newsletter!')
        ->set('form.author_name', 'John Doe')
        ->call('save')
        ->assertHasErrors(['form.text'])
        ->assertNoRedirect();

    expect(NewsletterTestimonial::count())->toBe(0);
});

it('can approve a testimonial via signed url', function () {
    $testimonial = NewsletterTestimonial::factory()->create([
        'is_active' => false,
    ]);

    $this->get($testimonial->approveUrl())
        ->assertOk()
        ->assertSee('Testimonial approved');

    expect($testimonial->fresh()->is_active)->toBeTrue();
});

it('can reject a testimonial via signed url', function () {
    $testimonial = NewsletterTestimonial::factory()->create([
        'is_active' => false,
    ]);

    $this->get($testimonial->rejectUrl())
        ->assertOk()
        ->assertSee('Testimonial rejected');

    expect(NewsletterTestimonial::find($testimonial->id))->toBeNull();
});

it('rejects unsigned testimonial approval urls', function () {
    $testimonial = NewsletterTestimonial::factory()->create([
        'is_active' => false,
    ]);

    $this->get("/testimonials/{$testimonial->id}/approve")
        ->assertForbidden();
});

it('does not show unapproved testimonials on the newsletter page', function () {
    NewsletterTestimonial::factory()->create([
        'text' => 'Pending testimonial',
        'is_active' => false,
    ]);

    $this->get('/newsletter')
        ->assertOk()
        ->assertDontSee('Pending testimonial');
})->skip('Testimonial ticker temporarily commented out');
