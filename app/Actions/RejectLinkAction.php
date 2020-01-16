<?php

namespace App\Actions;

use App\Models\Link;

class RejectLinkAction
{
    public function execute(Link $link)
    {
        $link->update(['status' => Link::STATUS_REJECTED]);

        return $link;
    }
}
