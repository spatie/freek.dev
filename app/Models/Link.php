<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\URL;

class Link extends Model implements Sluggable
{
    use HasFactory;

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

    public function approveUrl(): string
    {
        return URL::temporarySignedRoute(
            'link.approve', now()->addMonth(), ['link' => $this],
        );
    }

    public function approveAndCreatePostUrl(): string
    {
        return URL::temporarySignedRoute(
            'link.approve-and-create-post', now()->addMonth(), ['link' => $this],
        );
    }

    public function rejectUrl(): string
    {
        return URL::temporarySignedRoute(
            'link.reject', now()->addMonth(), ['link' => $this],
        );
    }
}
