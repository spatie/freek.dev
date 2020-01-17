<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Link extends Model implements Sluggable
{
    use HasSlug;

    public $dates = ['publish_date'];

    public const STATUS_SUBMITTED = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', static::STATUS_APPROVED);
    }

    public function getSluggableValue(): string
    {
        return $this->title;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function getHostUrlAttribute(): string
    {
        return parse_url($this->url)['host'] ?? '';
    }
}
