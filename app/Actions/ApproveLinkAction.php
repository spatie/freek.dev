<?php

namespace App\Actions;

use App\Enums\LinkStatus;
use App\Mail\LinkApprovedMail;
use App\Models\Link;
use Illuminate\Support\Facades\Mail;
use Spatie\ResponseCache\Facades\ResponseCache;

class ApproveLinkAction
{
    public function execute(Link $link): Link
    {
        if ($link->isApproved()) {
            return $link;
        }

        Mail::to($link->user->email)->queue(new LinkApprovedMail($link));

        $link->update([
            'publish_date' => now(),
            'status' => LinkStatus::Approved->value,
        ]);

        ResponseCache::clear();

        return $link;
    }
}
