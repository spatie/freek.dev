<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class Webmention extends Model
{
    use HasFactory;

    const TYPE_REPLY = 'reply';
    const TYPE_LIKE = 'like';
    const TYPE_RETWEET = 'retweet';

    public static function boot()
    {
        parent::boot();

        static::created(function () {
            ResponseCache::clear();
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeType(Builder $builder, string $type): void
    {
        $builder->where('type', $type);
    }

    public function getVerbAttribute(): string
    {
        $verbs = [
          static::TYPE_REPLY => 'replied',
          static::TYPE_RETWEET => 'retweeted',
          static::TYPE_LIKE => 'liked',
        ];

        return $verbs[$this->type];
    }
}
