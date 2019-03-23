<?php

namespace App\Models;

use App\Jobs\PostOnMediumJob;
use App\Jobs\SendTweetJob;
use App\Models\Presenters\PostPresenter;
use App\Services\CommonMark\CommonMark;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\ResponseCache\Facades\ResponseCache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

class Post extends BaseModel implements Feedable
{
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
                $dispatcher = static::getEventDispatcher();

                static::unsetEventDispatcher();

                $post->publish();

                static::setEventDispatcher($dispatcher);
            }

            ResponseCache::clear();
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('published', true);
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

        if ($this->published) {
            $this->publishOnSocialMedia();
        }

        ResponseCache::flush();

        return $this;
    }

    protected function publishOnSocialMedia()
    {
        if (!$this->tweet_sent) {
            if (! $this->concernsTweet()) {
                dispatch(new SendTweetJob($this));

                $this->tweet_sent = true;
                $this->save();
            }
        }

        if (!$this->posted_on_medium) {
            dispatch(new PostOnMediumJob($this));

            $this->posted_on_medium = true;
            $this->save();
        }
    }

    public function getWordpressFullUrlAttribute(): string
    {
        return "/{$this->publish_date->format('Y/m')}/{$this->wp_post_name}";
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
            'url' => url(route('posts.show', $this->slug)),
            'public_date' => $this->publish_date->timestamp,
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
            ->link(url(route('posts.show', $this->slug)))
            ->author('Freek Van der Herten');
    }

    public function concernsTweet(): bool
    {
        return $this->refresh()->tags->contains(function (Tag $tag) {
            return $tag->name === 'tweet';
        });
    }

    public function getUrlAttribute(): string
    {
        return route('posts.show', $this->slug);
    }

    public function getPromotionalUrlAttribute(): string
    {
        if (! empty($this->external_url)) {
            return $this->external_url;
        }

        return $this->url;
    }

    public function publish()
    {
        $this->published = true;

        if (! $this->publish_date) {
            $this->publish_date = now();
        }

        $this->save();

        Log::info("Post `{$this->title}` published.");

        if (app()->environment('production')) {
            $this->publishOnSocialMedia();
        }
    }

    public function scopeScheduled(Builder $query)
    {
        $query
            ->where('published', false)
            ->whereNotNull('publish_date');
    }
}
