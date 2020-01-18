<?php

namespace App\Http\Controllers\Links;

use App\Actions\CreateLinkAction;
use App\Http\Requests\CreateLinkRequest;

class CreateLinkController
{
    public function create()
    {
        return view('front.links.create');
    }

    public function store(CreateLinkRequest $request, CreateLinkAction $createLinkAction)
    {
        $createLinkAction->execute($request->validated(), auth()->user());

        return redirect()->route('links.thanks');
    }
}
