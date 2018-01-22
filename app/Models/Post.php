<?php

namespace App\Models;

use App\Jobs\PostOnMedium;
use App\Jobs\SendTweet;
use App\Models\Presenters\PostPresenter;
use App\Services\Parsedown;
use Illuminate\Database\Eloquent\Builder;
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

    public function getTextAttribute($original)
    {
        $text = $original;

        $text = str_replace('<pre><code>', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="js">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="bash">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="php">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="txt">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="html">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code class="yaml">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="js">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="bash">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="php">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="txt">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="html">', '```' . PHP_EOL, $text);

        $text = str_replace('<pre><code lang="yaml">', '```' . PHP_EOL, $text);

        $text = str_replace('</code></pre>', PHP_EOL . '```' . PHP_EOL, $text);

        $text = str_replace('</code>', '`', $text);

        $text = str_replace('<code>', '`', $text);

        $text = str_replace('</code>', '`', $text);

        $text = str_replace('[code lang="php"]', '```php'.PHP_EOL, $text);

        $text = str_replace('[/code]', '```' . PHP_EOL, $text);

        $text = str_replace('&gt;', '>', $text);

        $text = str_replace('&lt;', '<', $text);

        return (new Parsedown())->text($text);
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
        $this->original_content = $attributes['original_content'] ?? false;

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
            dispatch(new SendTweet($this));

            $this->tweet_sent = true;
            $this->save();

            flash()->info('Tweet was sent');
        }

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
        if (! $this->published) {
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
            ->summary($this->text)
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
