<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\ResponseCache\Facades\ResponseCache;

class Webmention extends Model
{
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
}
