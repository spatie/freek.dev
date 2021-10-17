<?php

namespace App\Models;

use App\Actions\ConvertPostTextToHtmlAction;
use App\Actions\PublishPostAction;
use App\Http\Controllers\PostController;
use App\Jobs\CreateOgImageJob;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sluggable;
use App\Models\Presenters\PostPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

class Post extends Model implements Feedable, Sluggable, HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const TYPE_LINK = 'link';
    public const TYPE_TWEET = 'tweet';
    public const TYPE_ORIGINAL = 'originalPost';

    use HasSlug,
        HasTags,
        PostPresenter;

    public $with = ['tags'];

    public $dates = ['publish_date'];

    public $casts = [
        'published' => 'boolean',
        'original_content' => 'boolean',
        'send_automated_tweet' => 'boolean',
    ];

    public static function booted()
    {
        static::creating(function (Post $post) {
            $post->preview_secret = Str::random(10);
        });


        static::saved(function (Post $post) {
            static::withoutEvents(function () use ($post) {
                (new ConvertPostTextToHtmlAction())->execute($post);

                if ($post->isPartOfSeries()) {
                    $post->getAllPostsInSeries()->each(function(Post $post) {
                        (new ConvertPostTextToHtmlAction())->execute($post);
                    });
                }
            });

            if ($post->published) {
                static::withoutEvents(function () use ($post) {
                    (new PublishPostAction())->execute($post);
                });

                return;
            }

            Bus::chain([
                new CreateOgImageJob($post),
                fn () => ResponseCache::clear(),
            ])->dispatch();
        });
    }

    public function submittedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    public function webmentions(): HasMany
    {
        return $this->hasMany(Webmention::class)->latest();
    }

    public function scopePublished(Builder $query)
    {
        $query
            ->where('published', true)
            ->orderBy('publish_date', 'desc')
            ->orderBy('id', 'desc');
    }

    public function scopeOriginalContent(Builder $query)
    {
        $query->where('original_content', true);
    }

    public function scopeScheduled(Builder $query)
    {
        $query
            ->where('published', false)
            ->whereNotNull('publish_date');
    }

    public function getHtmlWithExternalUrlAttribute()
    {
        $html = $this->html;

        if (! $this->isTweet() && $this->external_url) {
            $html .= PHP_EOL . PHP_EOL . "<a href='{$this->external_url}'>Read more</a>";
        }

        return $html;
    }

    public function updateAttributes(array $attributes)
    {
        $this->title = $attributes['title'];
        $this->text = $attributes['text'];
        $this->publish_date = $attributes['publish_date'];
        $this->published = $attributes['published'] ?? false;
        $this->original_content = $attributes['original_content'] ?? false;
        $this->external_url = $attributes['external_url'];

        $this->save();

        $tags = explode(',', $attributes['tags_text']);

        $tags = array_map(fn (string $tag) => trim(strtolower($tag)), $tags);

        $this->syncTags($tags);

        return $this;
    }

    public static function getFeedItems()
    {
        return static::published()
            ->orderBy('publish_date', 'desc')
            ->limit(20)
            ->get();
    }

    public static function getPhpFeedItems()
    {
        return static::withAnyTags(['php'])
            ->published()
            ->orderBy('publish_date', 'desc')
            ->limit(20)
            ->get();
    }

    public static function getOriginalContentFeedItems()
    {
        return static::published()
            ->where('original_content', true)
            ->orderBy('publish_date', 'desc')
            ->limit(20)
            ->get();
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->formatted_title)
            ->summary($this->html_with_external_url)
            ->updated($this->publish_date)
            ->link($this->url)
            ->authorName('Freek Van der Herten')
            ->authorEmail('freek@spatie.be');
    }

    public function getUrlAttribute(): string
    {
        return action(PostController::class, [$this->idSlug()]);
    }

    public function getPreviewUrlAttribute(): string
    {
        return action(PostController::class, [$this->idSlug()]) . "?preview_secret={$this->preview_secret}";
    }

    public function getPromotionalUrlAttribute(): string
    {
        if (! empty($this->external_url)) {
            return $this->external_url;
        }

        return $this->url;
    }

    public function hasTag(string $tagName): bool
    {
        return $this->refresh()
            ->tags
            ->contains(fn (Tag $tag) => $tag->name === $tagName);
    }

    public function isLink(): bool
    {
        return $this->getType() === static::TYPE_LINK;
    }

    public function isTweet(): bool
    {
        return $this->getType() === static::TYPE_TWEET;
    }

    public function isOriginal(): bool
    {
        return $this->getType() === static::TYPE_ORIGINAL;
    }

    public function getType(): string
    {
        if ($this->hasTag('tweet')) {
            return static::TYPE_TWEET;
        }

        if ($this->original_content) {
            return static::TYPE_ORIGINAL;
        }

        return static::TYPE_LINK;
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('ogImage')
            ->useDisk('og-images')
            ->singleFile();
    }

    public function getSluggableValue(): string
    {
        return $this->title;
    }

    public function toTweet(): string
    {
        $tags = $this->tags
            ->map(fn (Tag $tag) => $tag->name)
            ->map(fn (string $tagName) => '#' . str_replace(' ', '', $tagName))
            ->implode(' ');

        $twitterAuthorString = '';
        if ($twitterHandle = $this->authorTwitterHandle()) {
            $twitterAuthorString = " (by @{$twitterHandle})";
        }

        return $this->emoji . ' ' . $this->title . $twitterAuthorString
            . PHP_EOL . $this->promotional_url
            . PHP_EOL . $tags;
    }

    public function onAfterTweet(string $tweetUrl): void
    {
        $this->tweet_url = $tweetUrl;

        $this->save();
    }

    public function ogImageBaseUrl(): string
    {
        if ($this->external_url) {
            return $this->external_url;
        }

        return route('post.ogImage', $this) . "?preview_secret={$this->preview_secret}";
    }

    public function isPartOfSeries()
    {
        return ! empty($this->series_slug);
    }

    public function getAllPostsInSeries(): Collection
    {
        if (! $this->isPartOfSeries()) {
            return collect();
        }

        return Post::query()
            ->where('series_slug', $this->series_slug)
            ->orderBy('id')
            ->get();
    }

    public function authorTwitterHandle(): ?string
    {
        if ($this->author_twitter_handle) {
            return $this->author_twitter_handle;
        }

        if ($userTwitterHandle = optional($this->submittedByUser)->twitter_handle) {
            return $userTwitterHandle;
        }

        return null;
    }
}
