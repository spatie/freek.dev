<?php

namespace App\Http\Controllers;

use App\Actions\ApproveLinkAction;
use App\Actions\CreatePostFromLinkAction;
use App\Actions\RejectLinkAction;
use App\Models\Link;
use Illuminate\View\View;

class LinkApproval
{
    public function approve(Link $link, ApproveLinkAction $approveLinkAction): View
    {
        $approveLinkAction->execute($link);

        return view('front.links.approved');
    }

    public function approveAndCreatePost(
        Link $link,
        ApproveLinkAction $approveLinkAction,
        CreatePostFromLinkAction $createPostFromLinkAction
    ): View {
        $approveLinkAction->execute($link);

        $createPostFromLinkAction->execute($link);

        return view('front.links.approved-and-post-created');
    }

    public function reject(Link $link, RejectLinkAction $rejectLinkAction): View
    {
        $rejectLinkAction->execute($link);

        return view('front.links.rejected');
    }
}
