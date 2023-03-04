<?php

namespace App\Http\Controllers\Discovery;

use App\Models\Post;
use Illuminate\View\View;
use Spatie\RouteDiscovery\Attributes\Route;
use function view;

class HomeController
{
    #[Route(fullUri: '/')]
    public function __invoke(): View
    {
        resolve('here-we-go');

        $posts = Post::query()
            ->published()
            ->simplePaginate(20);

        return view('front.home.index', compact('posts'));
    }
}
