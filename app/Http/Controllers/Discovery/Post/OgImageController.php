<?php

namespace App\Http\Controllers\Discovery\Post;

use Illuminate\View\View;
use App\Models\Post;
use Spatie\RouteDiscovery\Attributes\Route;

class OgImageController
{
    #[Route(fullUri: '{post}/og-image', name: 'post.ogImage')]
    public function __invoke(Post $post): View
    {
        return view('front.posts.ogImage', compact('post'));
    }
}
