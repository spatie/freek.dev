<?php

namespace App\Http\Controllers\Links;

use App\Actions\ApproveLinkAction;
use App\Actions\CreatePostFromLinkAction;
use App\Models\Link;

class ApproveLinkAndCreatePostController
{
    public function __invoke(
        Link $link,
        ApproveLinkAction $approveLinkAction,
        CreatePostFromLinkAction $createPostFromLinkAction
    ) {
        $approveLinkAction->execute($link);

        $createPostFromLinkAction->execute($link);

        return view('front.links.approved-and-post-created');
    }
}
