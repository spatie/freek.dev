<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function __invoke()
    {
        return view('front.about.index');
    }
}
