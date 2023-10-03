<?php

namespace App\Actions;

use App\Enums\LinkStatus;
use App\Models\Link;

class RejectLinkAction
{
    public function execute(Link $link)
    {
        $link->update(['status' => LinkStatus::Rejected->value]);

        return $link;
    }
}
