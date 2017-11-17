<?php

namespace App\Http\Controllers\Front;

use Illuminate\Routing\Controller;

class NewsletterController extends Controller
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
