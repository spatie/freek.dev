<?php

namespace App\Models;

use App\Enums\LinkStatus;
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

    public $casts = [
        'publish_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', LinkStatus::Approved->value);
    }

    public function getSluggableValue(): string
    {
        return $this->title;
    }

    public function isApproved(): bool
    {
        return $this->status === LinkStatus::Approved->value;
    }

    public function isRejected(): bool
    {
        return $this->status === LinkStatus::Rejected->value;
    }

    public function getHostUrlAttribute(): string
    {
        return parse_url($this->url)['host'] ?? '';
    }

    public function approveUrl(): string
    {
        return URL::temporarySignedRoute(
            'link.approve',
            now()->addMonth(),
            ['link' => $this],
        );
    }

    public function approveAndCreatePostUrl(): string
    {
        return URL::temporarySignedRoute(
            'link.approve-and-create-post',
            now()->addMonth(),
            ['link' => $this],
        );
    }

    public function rejectUrl(): string
    {
        return URL::temporarySignedRoute(
            'link.reject',
            now()->addMonth(),
            ['link' => $this],
        );
    }
}
