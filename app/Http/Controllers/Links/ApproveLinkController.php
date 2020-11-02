<?php

namespace App\Http\Controllers\Links;

use App\Actions\ApproveLinkAction;
use App\Models\Link;

class ApproveLinkController
{
    public function __invoke(Link $link, ApproveLinkAction $approveLinkAction)
    {
        $approveLinkAction->execute($link);

        return view('front.links.approved');
    }
}
