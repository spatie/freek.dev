<?php

namespace App\Models;

use App\Jobs\PostOnMedium;
use App\Jobs\SendTweet;
use App\Models\Presenters\PostPresenter;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use Parsedown;
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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function scopePublished(Builder $query)
    {
        $query->where('published', true);
    }

    public function getTextAttribute()
    {
        $parseDown = new Parsedown();

        return $parseDown->text($this->getOriginal('text'));
    }

    public function getMarkdownAttribute()
    {
        return $this->getOriginal('text');
    }

    public function updateAttributes(array $attributes)
    {
        $this->title = $attributes['title'];
        $this->text = $attributes['text'];
        $this->publish_date = $attributes['publish_date'];
        $this->published = $attributes['published'] ?? false;

        $this->save();

        $tags = array_map(function(string $tag) {
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
        /*
        if (!$this->tweet_sent) {
            dispatch(new SendTweet($this));

            $this->tweet_sent = true;
            $this->save();

            flash()->info('Tweet was sent');
        }
        */


        if (!$this->posted_on_medium) {
            dispatch(new PostOnMedium($this));

            $this->posted_on_medium = true;
            $this->save();

            flash()->info('Posted on medium');
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
        if ($this->published) {
            return [];
        }

        return [
            'title' => $this->title,
            'url' => url(action('Front\PostsController@detail', $this->slug)),
            'public_date' => $this->publish_date->timestamp,
            'text' => substr(strip_tags($this->text), 0, 5000),
            'tags' => $this->tags->implode(',')
        ];
    }

    public static function getFeedItems()
    {
        return static::where('published', true)
            ->orderBy('publish_date', 'desc')
            ->limit(100)
            ->get();
    }

    public static function getPhpFeedItems()
    {
        return static::withAnyTags(['php'])
            ->where('published', true)
            ->orderBy('publish_date', 'desc')
            ->limit(100)
            ->get();
    }

    public function toFeedItem()
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->excerpt)
            ->updated($this->updated_at)
            ->link(url(action('Front\PostsController@detail', $this->slug)))
            ->author('Freek Van der Herten');
    }

    public function concernsTweet(): bool
    {
        return $this->tags->contains(function (Tag $tag) {
            return $tag->name === 'tweet';
        });
    }

    public function getUrlAttribute(): string
    {
        return action('Front\PostsController@detail', $this->slug);
    }
}
