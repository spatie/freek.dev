<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\View\View;

class CommunityController
{
    public function index(): View
    {
        $links = Link::query()
            ->latest()
            ->approved()
            ->simplePaginate(20);

        return view('front.pages.community.index', compact('links'));
    }

    public function create(): View
    {
        return view('front.pages.community.create');
    }

    public function thanks(): View
    {
        return view('front.pages.community.thanks');
    }
}
