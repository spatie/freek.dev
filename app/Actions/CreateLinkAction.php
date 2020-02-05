<?php

namespace App\Actions;

use App\Mail\LinkSumittedMail;
use App\Models\Link;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CreateLinkAction
{
    public function execute(array $linkAttributes, User $user)
    {
        $link = Link::create([
            'title' => $linkAttributes['title'],
            'url' => $linkAttributes['url'],
            'text' => $linkAttributes['text'] ?? '',
            'user_id' => $user->id,
        ]);

        Mail::to('freek@spatie.be')->queue(new LinkSumittedMail($link));
    }
}
