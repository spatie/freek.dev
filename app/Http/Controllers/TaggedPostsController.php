<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Spatie\Tags\Tag;

class TaggedPostsController
{
    public function __invoke(string $tagSlug): View
    {
        $tag = Tag::query()
            ->where('slug->en', $tagSlug)
            ->firstOrFail();

        $posts = Post::withAnyTags([$tag])
            ->published()
            ->simplePaginate(20);

        return view('front.pages.tagged-posts', compact('tag', 'posts'));
    }
}
