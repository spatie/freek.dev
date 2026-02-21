<?php

namespace App\Mail;

use App\Models\NewsletterTestimonial;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestimonialSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public NewsletterTestimonial $testimonial
    ) {}

    public function build(): static
    {
        return $this->markdown('mails.testimonials.submitted');
    }
}
