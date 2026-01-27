<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class OgImageController
{
    public function __invoke(Post $post): View
    {
        return view('front.pages.og-image', compact('post'));
    }
}
