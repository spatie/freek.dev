<?php

namespace App\Http\Controllers\Links;

use App\Http\Requests\CreateLinkRequest;
use App\Models\Link;

class CreateLinkController
{
    public function __invoke(CreateLinkRequest $request)
    {
        Link::create([
            'title' => $request->title,
            'url' => $request->url,
            'text' => $request->text,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->to('front.links.thanks');
    }
}
