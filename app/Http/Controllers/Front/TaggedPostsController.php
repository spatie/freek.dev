<?php

namespace App\Http\Controllers\Front;

use App\Models\Post;
use Illuminate\Routing\Controller;
use Spatie\Tags\Tag;

class TaggedPostsController extends Controller
{
    public function index(Tag $tag)
    {
        $posts = Post::published()
            ->orderBy('publish_date', 'desc')
            ->withAllTags([$tag])
            ->simplePaginate(50);

        return view('front.taggedPosts.index', compact('tag', 'posts'));
    }
}
