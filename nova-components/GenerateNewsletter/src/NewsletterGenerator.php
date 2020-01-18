<?php

namespace Freekmurze\GenerateNewsletter;

use App\Models\Link;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use NumberFormatter;

class NewsletterGenerator
{
    /** @var \Carbon\Carbon */
    protected $startDate;

    /** @var \Carbon\Carbon */
    protected $endDate;

    /** @var string */
    protected $editionNumber;

    public function __construct(Carbon $startDate, Carbon $endDate, int $editionNumber)
    {
        $this->startDate = $startDate;

        $this->endDate = $endDate;

        $this->editionNumber = $this->ordinal($editionNumber);
    }

    public function getHtml()
    {
        $recentPosts = $this->getRecentPosts();
        $recentTweets = $this->getRecentTweets();
        $communityLinks = $this->getRecentCommunityLinks();
        $oldPosts = $this->getOldPosts();
        $editionNumber = $this->editionNumber;

        return view('generate-newsletter::template', compact(
            'recentPosts',
            'recentTweets',
            'communityLinks',
            'oldPosts',
            'editionNumber',
        ))->render();
    }

    protected function getRecentPosts(): Collection
    {
        return $this->getPosts(
            $this->startDate->startOfDay(),
            $this->endDate->endOfDay()
        );
    }

    protected function getRecentTweets(): Collection
    {
        return $this->getPosts(
            $this->startDate->startOfDay(),
            $this->endDate->endOfDay(),
            true
        );
    }

    public function getRecentCommunityLinks(): Collection
    {
        return Link::approved()
            ->whereBeteen('publish_date', [
                $this->startDate->startOfDay(),
                $this->endDate->endOfDay(),
            ])
            ->where('url')
            ->get()
            ->reject(fn (Link $link) => Post::where('external_url', $link->url)->exists);
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
            ->$method->hasTag('tweet');
    }

    private function ordinal(int $number): string
    {
        return (new NumberFormatter('en_US', NumberFormatter::ORDINAL))->format($number);
    }
}
