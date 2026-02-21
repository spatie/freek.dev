<?php

namespace App\Actions;

use App\Mail\TestimonialSubmittedMail;
use App\Models\NewsletterTestimonial;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;

class CreateTestimonialAction
{
    public function execute(array $attributes, ?UploadedFile $avatar = null): NewsletterTestimonial
    {
        $testimonial = NewsletterTestimonial::create([
            'text' => $attributes['text'],
            'author_name' => $attributes['author_name'],
            'author_title' => $attributes['author_title'] ?? '',
            'author_url' => $attributes['author_url'] ?? '',
            'is_active' => false,
        ]);

        if ($avatar) {
            $testimonial
                ->addMedia($avatar)
                ->toMediaCollection('avatar');
        }

        Mail::to('freek@spatie.be')->queue(new TestimonialSubmittedMail($testimonial));

        return $testimonial;
    }
}
