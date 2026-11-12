<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitoredFeed extends Model
{
    protected $hidden = ['url_hash'];

    protected function casts(): array
    {
        return [
            'enabled' => 'boolean',
            'baseline_before' => 'datetime',
            'last_checked_at' => 'datetime',
        ];
    }

    public function seenItems(): HasMany
    {
        return $this->hasMany(SeenFeedItem::class);
    }
}
