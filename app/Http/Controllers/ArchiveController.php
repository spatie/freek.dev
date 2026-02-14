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

        $yearIndex = $availableYears->search($year);
        $years = $availableYears->slice($yearIndex, 3)->values();

        $postsByYear = $years->mapWithKeys(function (int $y) {
            $posts = Post::query()
                ->published()
                ->whereNotNull('publish_date')
                ->whereYear('publish_date', $y)
                ->get()
                ->groupBy(fn (Post $post) => $post->publish_date->format('F'));

            return [$y => $posts];
        });

        $previousYear = $availableYears->first(fn (int $availableYear) => $availableYear < $years->last());
        $nextYear = $availableYears->first(fn (int $availableYear) => $availableYear > $year);

        return view('front.pages.archive', [
            'postsByYear' => $postsByYear,
            'year' => $year,
            'previousYear' => $previousYear,
            'nextYear' => $nextYear,
        ]);
    }
}
