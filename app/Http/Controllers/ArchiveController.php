<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class ArchiveController
{
    public function __invoke(?int $year = null): View
    {
        $availableYears = Post::query()
            ->where('published', true)
            ->whereNotNull('publish_date')
            ->selectRaw('YEAR(publish_date) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $year = $year ?? $availableYears->first();

        $posts = Post::query()
            ->published()
            ->whereNotNull('publish_date')
            ->whereYear('publish_date', $year)
            ->get()
            ->groupBy(fn (Post $post) => $post->publish_date->format('F'));

        $previousYear = $availableYears->first(fn (int $availableYear) => $availableYear < $year);
        $nextYear = $availableYears->first(fn (int $availableYear) => $availableYear > $year);

        return view('front.pages.archive', [
            'posts' => $posts,
            'year' => $year,
            'previousYear' => $previousYear,
            'nextYear' => $nextYear,
        ]);
    }
}
