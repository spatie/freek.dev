<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Tags\Tag;

class TopicsController
{
    public function index(): View
    {
        $publishedPostCountSubquery = DB::table('taggables')
            ->join('posts', function ($join) {
                $join->on('taggables.taggable_id', '=', 'posts.id')
                    ->where('taggables.taggable_type', (new Post)->getMorphClass());
            })
            ->where('posts.published', true)
            ->whereColumn('taggables.tag_id', 'tags.id')
            ->selectRaw('count(*)');

        $originalCountSubquery = DB::table('taggables')
            ->join('posts', function ($join) {
                $join->on('taggables.taggable_id', '=', 'posts.id')
                    ->where('taggables.taggable_type', (new Post)->getMorphClass());
            })
            ->where('posts.published', true)
            ->where('posts.original_content', true)
            ->whereColumn('taggables.tag_id', 'tags.id')
            ->selectRaw('count(*)');

        $topics = Tag::query()
            ->select('tags.*')
            ->selectSub($publishedPostCountSubquery, 'published_post_count')
            ->selectSub($originalCountSubquery, 'original_count')
            ->having('published_post_count', '>', 20)
            ->orderByDesc('published_post_count')
            ->get();

        return view('front.pages.topics.index', compact('topics'));
    }

    public function show(string $tagSlug): View
    {
        $tag = Tag::query()
            ->where('slug->en', $tagSlug)
            ->firstOrFail();

        $featuredPosts = Post::withAnyTags([$tag])
            ->published()
            ->originalContent()
            ->limit(3)
            ->get();

        $posts = Post::withAnyTags([$tag])
            ->published()
            ->simplePaginate(20);

        $totalCount = Post::withAnyTags([$tag])
            ->where('published', true)
            ->count();

        $originalCount = Post::withAnyTags([$tag])
            ->where('published', true)
            ->where('original_content', true)
            ->count();

        $relatedTags = Tag::query()
            ->select('tags.*')
            ->selectRaw('COUNT(*) as overlap_count')
            ->join('taggables as t1', 'tags.id', '=', 't1.tag_id')
            ->join('taggables as t2', 't1.taggable_id', '=', 't2.taggable_id')
            ->where('t2.tag_id', $tag->id)
            ->where('tags.id', '!=', $tag->id)
            ->where('t1.taggable_type', (new Post)->getMorphClass())
            ->where('t2.taggable_type', (new Post)->getMorphClass())
            ->groupBy('tags.id')
            ->orderByDesc('overlap_count')
            ->limit(5)
            ->get();

        return view('front.pages.topics.show', compact(
            'tag',
            'featuredPosts',
            'posts',
            'totalCount',
            'originalCount',
            'relatedTags',
        ));
    }
}
