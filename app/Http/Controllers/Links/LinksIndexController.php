<?php

namespace App\Http\Controllers\Links;

use App\Models\Link;

class LinksIndexController
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
