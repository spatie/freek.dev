<?php

namespace App\Http\Controllers;

use App\Models\NewsletterTestimonial;
use Illuminate\View\View;

class TestimonialApprovalController
{
    public function approve(NewsletterTestimonial $testimonial): View
    {
        $testimonial->update(['is_active' => true]);

        return view('front.testimonials.approved');
    }

    public function reject(NewsletterTestimonial $testimonial): View
    {
        $testimonial->delete();

        return view('front.testimonials.rejected');
    }
}
