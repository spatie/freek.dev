<?php

namespace App\Http\Controllers\Discovery\Community;

use App\Models\Link;
use Illuminate\View\View;
use function view;

class IndexController
{
    public function __invoke(): View
    {
        $links = Link::query()
            ->latest()
            ->approved()
            ->simplePaginate(20);

        return view('front.links.index', compact('links'));
    }
}
