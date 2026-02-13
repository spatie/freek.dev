<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PopularPostsService;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Tags\Tag;

class HomeController
{
    public function __invoke(PopularPostsService $popularPostsService): View
    {
        $posts = Post::query()
            ->published()
            ->simplePaginate(20);

        if (! $posts->onFirstPage()) {
            return view('front.pages.home', compact('posts'));
        }

        $priorityTags = ['laravel', 'php', 'ai'];

        $topTags = Tag::query()
            ->select('tags.*')
            ->selectSub(
                DB::table('taggables')
                    ->join('posts', function ($join) {
                        $join->on('taggables.taggable_id', '=', 'posts.id')
                            ->where('taggables.taggable_type', (new Post)->getMorphClass());
                    })
                    ->whereNotNull('posts.publish_date')
                    ->where('posts.published', true)
                    ->whereColumn('taggables.tag_id', 'tags.id')
                    ->selectRaw('count(*)'),
                'published_post_count'
            )
            ->having('published_post_count', '>', 0)
            ->orderByDesc('published_post_count')
            ->limit(10)
            ->get();

        $topTags = $topTags->filter(fn (Tag $tag) => in_array($tag->name, $priorityTags))
            ->sortBy(fn (Tag $tag) => array_search($tag->name, $priorityTags))
            ->merge($topTags->reject(fn (Tag $tag) => in_array($tag->name, $priorityTags)))
            ->values();

        $popularPosts = $popularPostsService->getPopularPosts(8);

        return view('front.pages.home', compact('posts', 'topTags', 'popularPosts'));
    }
}
