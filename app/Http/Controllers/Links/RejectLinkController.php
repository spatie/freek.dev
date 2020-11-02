<?php

namespace App\Http\Controllers\Links;

use App\Actions\RejectLinkAction;
use App\Models\Link;

class RejectLinkController
{
    public function __invoke(Link $link, RejectLinkAction $rejectLinkAction)
    {
        $rejectLinkAction->execute($link);

        return view('front.links.rejected');
    }
}
