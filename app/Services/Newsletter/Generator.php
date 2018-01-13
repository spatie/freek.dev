<?php

namespace App\Services\Newsletter;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Generator
{
    /** @var \Carbon\Carbon */
    protected $endDate;

    /** @var int */
    protected $editionNumber;

    public function __construct(Carbon $endDate, int $editionNumber)
    {
        $this->endDate = $endDate;

        $this->editionNumber = $editionNumber;
    }

    public function getHtml()
    {
        $recentPosts = $this->getRecentPosts();
        $recentTweets = $this->getRecentTweets();
        $oldPosts = $this->getOldPosts();
        $editionNumber = $this->editionNumber;

        return view('back.newsletterGenerator.template', compact(
           'recentPosts',
           'recentTweets',
           'oldPosts',
           'editionNumber'
        ))->render();
    }

    protected function getRecentPosts(): Collection
    {
        return $this->getPosts(
            $this->endDate->copy()->subWeek(2)->startOfDay(),
            $this->endDate->endOfDay()
        );
    }

    protected function getRecentTweets(): Collection
    {
        return $this->getPosts(
            $this->endDate->copy()->subWeek(2)->startOfDay(),
            $this->endDate->endOfDay(),
            true
        );
    }

    protected function getOldPosts(): Collection
    {
        return $this->getPosts(
            $this->endDate->copy()->subYear()->subWeek(2)->startOfDay(),
            $this->endDate->subYear()->endOfDay()
        );
    }

    protected function getPosts(Carbon $startDate, Carbon $endDate, bool $tweets = false): Collection
    {
        $method = $tweets ? 'filter' : 'reject';

        return Post::published()
            ->whereBetween('publish_date', [
                $startDate,
                $endDate
            ])
            ->orderBy('original_content', 'desc')
            ->get()
            ->$method->concernsTweet();
    }
}
