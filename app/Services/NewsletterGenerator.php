<?php

namespace App\Services;

use App\Models\Link;
use App\Models\Post;
use App\Services\Utm\UtmParameters;
use App\Services\Utm\UtmTagger;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use NumberFormatter;

class NewsletterGenerator
{
    public function __construct(
        protected Carbon $startDate,
        protected Carbon $endDate,
        protected int $editionNumber,
    ) {}

    public function getMarkdown(): string
    {
        $recentPosts = $this->getRecentPosts();
        $recentTweets = $this->getRecentTweets();
        $communityLinks = $this->getRecentCommunityLinks();
        $oldPosts = $this->getOldPosts();
        $editionNumber = $this->ordinal($this->editionNumber);

        $markdown = view('newsletter.template', compact(
            'recentPosts',
            'recentTweets',
            'communityLinks',
            'oldPosts',
            'editionNumber',
        ))->render();

        return UtmTagger::tagMarkdown($markdown, UtmParameters::forNewsletter($this->editionNumber));
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
        $links = Link::query()
            ->with('user')
            ->approved()
            ->whereBetween('publish_date', [
                $this->startDate->startOfDay(),
                $this->endDate->endOfDay(),
            ])
            ->get();

        $existingUrls = Post::query()
            ->whereIn('external_url', $links->pluck('url')->filter())
            ->pluck('external_url')
            ->flip();

        return $links->reject(fn (Link $link) => $existingUrls->has($link->url));
    }

    protected function getOldPosts(): Collection
    {
        return $this->getPosts(
            $this->endDate->copy()->subYear()->subWeeks(2)->startOfDay(),
            $this->endDate->subYear()->endOfDay()
        );
    }

    protected function getPosts(Carbon $startDate, Carbon $endDate, bool $tweets = false): Collection
    {
        $method = $tweets ? 'filter' : 'reject';

        return Post::query()
            ->published()
            ->whereBetween('publish_date', [
                $startDate,
                $endDate,
            ])
            ->get()
            ->$method->hasTag('tweet')
            ->sort(function (Post $a, Post $b) {
                return ($b->original_content <=> $a->original_content)
                    ?: ($a->hasTag('php') <=> $b->hasTag('php'));
            })
            ->values();
    }

    protected function ordinal(int $number): string
    {
        return (new NumberFormatter('en_US', NumberFormatter::ORDINAL))->format($number);
    }
}
