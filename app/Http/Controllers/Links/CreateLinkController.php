<?php

namespace App\Http\Controllers\Links;

use App\Http\Requests\CreateLinkRequest;
use App\Models\Link;

class CreateLinkController
{
    public function create()
    {
        return view('front.links.create');
    }

    public function store(CreateLinkRequest $request)
    {
        Link::create([
            'title' => $request->title,
            'url' => $request->url,
            'text' => $request->text,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('links.thanks');
    }
}
