<?php

namespace App\Actions;

use App\Models\Link;
use App\Models\Post;

class CreatePostFromLinkAction
{
    public function execute(Link $link)
    {
        Post::create([
            'submitted_by_user_id' => $link->user_id,
            'title' => $link->title,
            'text' => $link->text,
            'external_url' => $link->external_url,
            'published' => false,
        ]);
    }
}
