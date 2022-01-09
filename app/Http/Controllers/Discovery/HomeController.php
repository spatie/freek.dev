<?php

namespace App\Http\Controllers\Discovery;

use App\Models\Post;
use Spatie\RouteDiscovery\Attributes\Route;
use function view;

class HomeController
{
    #[Route(fullUri: '/')]
    public function __invoke()
    {
        $posts = Post::query()
            ->published()
            ->simplePaginate(20);

        return view('front.home.index', compact('posts'));
    }
}
