<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;

class NewsletterController
{
    public function __invoke()
    {
        $newsletters = Newsletter::orderByDesc('sent_at')->take(100)->get();

        return view('front.newsletter.index', compact('newsletters'));
    }
}
