<?php

namespace App\Http\Controllers\Links;

class LinksIndexController
{
    public function __invoke()
    {
        $links = Link::query()
            ->latest()
            ->approved()
            ->paginate();

        return view('front.links.index', compact('links'));
    }
}
