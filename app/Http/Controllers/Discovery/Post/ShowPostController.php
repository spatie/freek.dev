<?php

namespace App\Http\Controllers\Discovery\Post;

use App\Models\Ad;
use App\Models\Post;
use Spatie\RouteDiscovery\Attributes\Route;

class ShowPostController
{
    #[Route(fullUri: '{postSlug}', name: 'post')]
    public function __invoke(Post $post)
    {
        $ad = Ad::getForCurrentPage();

        return view('front.posts.show', compact('post', 'ad'));
    }
}
