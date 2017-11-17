<?php

namespace App\Http\Controllers\Front;

use Illuminate\Routing\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return view('front.about.index');
    }
}
