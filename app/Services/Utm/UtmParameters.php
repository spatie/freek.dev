<?php

namespace App\Services\Utm;

use App\Models\Ad;
use App\Models\Link;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Support\Str;

readonly class UtmParameters
{
    public function __construct(
        public string $source,
        public string $medium,
        public string $campaign,
    ) {}

    public static function forPost(Post $post): self
    {
        return new self('freek.dev', 'referral', "blogpost-{$post->idSlug()}");
    }

    public static function forLink(Link $link): self
    {
        return new self('freek.dev', 'referral', "community-link-{$link->id}-{$link->slug}");
    }

    public static function forAd(Ad $ad): self
    {
        return new self('freek.dev', 'banner', "ad-{$ad->id}");
    }

    public static function forVideo(Video $video): self
    {
        return new self('freek.dev', 'referral', "video-{$video->id}-".Str::slug($video->title));
    }

    public static function forNewsletter(int $editionNumber): self
    {
        return new self('newsletter', 'email', "freek-dev-issue-{$editionNumber}");
    }

    public static function forTwitter(Post $post): self
    {
        return self::forSocialNetwork('twitter', $post);
    }

    public static function forMastodon(Post $post): self
    {
        return self::forSocialNetwork('mastodon', $post);
    }

    public static function forBluesky(Post $post): self
    {
        return self::forSocialNetwork('bluesky', $post);
    }

    protected static function forSocialNetwork(string $network, Post $post): self
    {
        return new self($network, 'social', "blogpost-{$post->idSlug()}");
    }

    /** @return array{utm_source: string, utm_medium: string, utm_campaign: string} */
    public function toArray(): array
    {
        return [
            'utm_source' => $this->source,
            'utm_medium' => $this->medium,
            'utm_campaign' => $this->campaign,
        ];
    }
}
