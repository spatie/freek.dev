<?php

namespace App\Http\Controllers;

use App\Actions\ApproveLinkAction;
use App\Actions\CreatePostFromLinkAction;
use App\Actions\RejectLinkAction;
use App\Models\Link;
use Illuminate\View\View;

class LinkApprovalController
{
    public function approve(Link $link, ApproveLinkAction $approveLinkAction): View
    {
        if ($link->isApproved()) {
            return view('front.links.already-approved');
        }

        $approveLinkAction->execute($link);

        return view('front.links.approved');
    }

    public function approveAndCreatePost(
        Link $link,
        ApproveLinkAction $approveLinkAction,
        CreatePostFromLinkAction $createPostFromLinkAction
    ): View {
        if ($link->isApproved()) {
            return view('front.links.already-approved');
        }

        $approveLinkAction->execute($link);

        $publishDate = $createPostFromLinkAction->execute($link);

        return view('front.links.approved-and-post-created', compact('publishDate'));
    }

    public function reject(Link $link, RejectLinkAction $rejectLinkAction): View
    {
        $rejectLinkAction->execute($link);

        return view('front.links.rejected');
    }
}
