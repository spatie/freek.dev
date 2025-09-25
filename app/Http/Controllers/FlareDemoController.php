<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;

class FlareDemoController
{
    public function index()
    {
        $posts = Post::published()
            ->limit(10)
            ->get()
            ->map(function ($post) {
                return (object) [
                    'id' => $post->id,
                    'title' => $post->title,
                    'excerpt' => $post->summary ?? Str::limit(strip_tags($post->text), 200),
                    'author' => 'Freek Van der Herten',
                    'date' => $post->publish_date->format('M j, Y'),
                    'reading_time' => $post->minutes_to_read.' min read',
                    'category' => $post->tags->first()?->name ?? 'General',
                    'tags' => $post->tags->pluck('name')->toArray(),
                    'views' => $post->views ?? 0,
                    'comments' => $post->comments()->count(),
                ];
            });

        return viiew('flare-demo', compact('posts'));
    }
}
