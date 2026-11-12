<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeenFeedItem extends Model
{
    protected $hidden = ['identifier_hash', 'url_hash'];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'seen_at' => 'datetime',
        ];
    }

    public function feed(): BelongsTo
    {
        return $this->belongsTo(MonitoredFeed::class, 'monitored_feed_id');
    }
}
