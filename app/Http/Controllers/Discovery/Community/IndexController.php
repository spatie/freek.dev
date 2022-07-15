<?php

namespace App\Http\Controllers\Discovery\Community;

use App\Models\Link;
use function view;

class IndexController
{
    public function __invoke()
    {
        $links = Link::query()
            ->latest()
            ->approved()
            ->simplePaginate(20);

        return view('front.links.index', compact('links'));
    }
}
