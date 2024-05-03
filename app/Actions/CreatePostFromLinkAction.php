<?php

namespace App\Actions;

use App\Models\Link;
use App\Models\Post;
use Carbon\Carbon;

class CreatePostFromLinkAction
{
    public function execute(Link $link): Carbon
    {
        $publishDate = $this->determinePublishDate($link);

        Post::create([
            'submitted_by_user_id' => $link->user_id,
            'title' => $link->title,
            'text' => $link->text,
            'external_url' => $link->url,
            'published' => false,
            'publish_date' => $this->determinePublishDate($link),
        ]);

        return $publishDate;
    }

    protected function determinePublishDate(Link $link): Carbon
    {
        $publishDate = now()->addDay()->hour(14);

        // If the date falls on a weekend or a post already exists on this date, increment the date
        while ($publishDate->isWeekend() || Post::whereDate('publish_date', $publishDate)->exists()) {
            $publishDate->addDay();
        }

        return $publishDate;
    }
}
