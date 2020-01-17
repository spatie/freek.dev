<?php

namespace App\Http\Controllers\Links;

use App\Models\Link;

class LinksIndexController
{
    public function __invoke()
    {
        $links = Link::query()
            ->latest()
            ->where('user_id', optional(auth()->user())->id)
            //->approved()
            ->simplePaginate(4);

        return view('front.links.index', compact('links'));
    }
}
