<?php

namespace App\Http\Controllers\Discovery\Community;

use App\Actions\CreateLinkAction;
use App\Http\Requests\CreateLinkRequest;
use Spatie\RouteDiscovery\Attributes\Route;

#[Route(middleware: ['auth', 'doNotCacheResponse'])]
class LinkController
{
    public function create()
    {
        return view('front.links.create');
    }

    public function store(CreateLinkRequest $request, CreateLinkAction $createLinkAction)
    {
        $createLinkAction->execute($request->validated(), auth()->user());

        return redirect()->route('community.thanks');
    }
}
