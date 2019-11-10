<?php

namespace App\Http\Controllers\NewsletterSubscription;

class ConfirmNewsletterSubscriptionController
{
    public function __invoke()
    {
        return view('front.newsletterSubscription.confirm');
    }
}
