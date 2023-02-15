<?php

namespace App\Http\Controllers\Discovery\Community;

use App\Actions\ApproveLinkAction;
use App\Actions\CreatePostFromLinkAction;
use App\Actions\RejectLinkAction;
use App\Models\Link;
use Illuminate\View\View;
use Spatie\RouteDiscovery\Attributes\Route;

#[Route(middleware: 'signed')]
class LinkApproval
{
    #[Route(name: 'link.approve')]
    public function approve(Link $link, ApproveLinkAction $approveLinkAction): View
    {
        $approveLinkAction->execute($link);

        return view('front.links.approved');
    }

    #[Route(name: 'link.approve-and-create-post')]
    public function approveAndCreatePost(
        Link $link,
        ApproveLinkAction $approveLinkAction,
        CreatePostFromLinkAction $createPostFromLinkAction
    ): View {
        $approveLinkAction->execute($link);

        $createPostFromLinkAction->execute($link);

        return view('front.links.approved-and-post-created');
    }

    #[Route(name: 'link.reject')]
    public function reject(Link $link, RejectLinkAction $rejectLinkAction): View
    {
        $rejectLinkAction->execute($link);

        return view('front.links.rejected');
    }
}
