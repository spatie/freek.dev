<?php

namespace App\Http\Controllers;

class NewsletterController
{
    public function index()
    {
        return view('front.newsletter.index');
    }

    public function confirm()
    {
        return view('front.newsletter.confirm');
    }

    public function subscribed()
    {
        return view('front.newsletter.subscribed');
    }
}
