<?php

namespace App\Http\Controllers\Discovery;

use Illuminate\View\View;
use App\Models\Post;
use Spatie\RouteDiscovery\Attributes\Route;
use function view;

class HomeController
{
    #[Route(fullUri: '/')]
    public function __invoke(): View
    {
        $posts = Post::query()
            ->published()
            ->simplePaginate(20);

        return view('front.home.index', compact('posts'));
    }
}
