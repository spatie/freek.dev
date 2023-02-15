<?php

namespace App\Http\Controllers\Discovery\Community;

use App\Actions\CreateLinkAction;
use App\Http\Requests\CreateLinkRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\RouteDiscovery\Attributes\Route;

#[Route(middleware: ['auth', 'verified', 'doNotCacheResponse'])]
class LinkController
{
    public function create(): View
    {
        return view('front.links.create');
    }

    public function store(CreateLinkRequest $request, CreateLinkAction $createLinkAction): RedirectResponse
    {
        $createLinkAction->execute($request->validated(), auth()->user());

        return redirect()->route('community.thanks');
    }
}
