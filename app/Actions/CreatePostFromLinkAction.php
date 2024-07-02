<?php

namespace App\Actions;

use App\Models\Link;
use App\Models\Post;
use Carbon\Carbon;

class CreatePostFromLinkAction
{
    public function execute(Link $link): Carbon
    {
        $publishDate = Post::nextFreePublishDate();

        Post::create([
            'submitted_by_user_id' => $link->user_id,
            'title' => $link->title,
            'text' => $link->text,
            'external_url' => $link->url,
            'published' => false,
            'publish_date' => $publishDate,
        ]);

        return $publishDate;
    }
}
