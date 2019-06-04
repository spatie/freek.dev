<?php

namespace App\Models;

use App\Actions\PublishPostAction;
use App\Http\Controllers\PostController;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sluggable;
use App\Models\Presenters\PostPresenter;
use App\Services\CommonMark\CommonMark;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

class Post extends Model implements Feedable, Sluggable
{
    public const TYPE_LINK = 'link';
    public const TYPE_TWEET = 'tweet';
    public const TYPE_ORIGINAL = 'originalPost';

    use HasSlug,
        HasTags,
        PostPresenter,
        Searchable;

    public $with = ['tags'];

    public $dates = ['publish_date'];

    public $casts = [
        'published' => 'boolean',
        'original_content' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::saved(function (Post $post) {
            if ($post->published) {
                static::withoutEvents(function () use ($post) {
                    (new PublishPostAction())->execute($post);
                });
            }
        });
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

    public function getFormattedTextAttribute()
    {
        return CommonMark::convertToHtml($this->text);
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

        $tags = array_map(function (string $tag) {
            return trim(strtolower($tag));
        }, explode(',', $attributes['tags_text']));

        $this->syncTags($tags);

        return $this;
    }

    public function searchableAs(): string
    {
        return config('scout.algolia.index');
    }

    public function toSearchableArray(): array
    {
        if (! $this->published) {
            return [];
        }

        return [
            'title' => $this->title,
            'url' => $this->url,
            'publish_date' => optional($this->publish_date)->timestamp,
            'formatted_publish_date' => optional($this->publish_date)->format('M jS Y'),
            'type' => $this->getType(),
            'formatted_type' => $this->formatted_type,
            'text' => substr(strip_tags($this->text), 0, 5000),
            'tags' => $this->tags->implode(',')
        ];
    }

    public static function getFeedItems()
    {
        return static::published()
            ->orderBy('publish_date', 'desc')
            ->limit(100)
            ->get();
    }

    public static function getPhpFeedItems()
    {
        return static::withAnyTags(['php'])
            ->published()
            ->orderBy('publish_date', 'desc')
            ->limit(100)
            ->get();
    }

    public static function getOriginalContentFeedItems()
    {
        return static::published()
            ->where('original_content', true)
            ->orderBy('publish_date', 'desc')
            ->limit(100)
            ->get();
    }

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->formatted_title)
            ->summary($this->formatted_text)
            ->updated($this->publish_date)
            ->link($this->url)
            ->author('Freek Van der Herten');
    }

    public function getUrlAttribute(): string
    {
        return action(PostController::class, [$this->idSlug()]);
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
        return $this->refresh()->tags->contains(function (Tag $tag) use ($tagName) {
            return $tag->name === $tagName;
        });
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
        if (! empty($this->external_url)) {
            return static::TYPE_LINK;
        }

        if ($this->hasTag('tweet')) {
            return static::TYPE_TWEET;
        }

        return static::TYPE_ORIGINAL;
    }

    public function getSluggableValue(): string
    {
        return $this->title;
    }
}
