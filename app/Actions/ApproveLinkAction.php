<?php

namespace App\Actions;

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
            'status' => Link::STATUS_APPROVED,
            'publish_date' => now(),
        ]);

        ResponseCache::clear();

        return $link;
    }
}
