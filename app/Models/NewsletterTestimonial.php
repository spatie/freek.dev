<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class NewsletterTestimonial extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->useDisk('avatars')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->width(1024)
            ->height(1024)
            ->nonQueued();
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::get(function (?string $value): string {
            $media = $this->getFirstMedia('avatar');

            if ($media) {
                return $media->getUrl('avatar');
            }

            return $value ?? '';
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function approveUrl(): string
    {
        return URL::temporarySignedRoute(
            'testimonial.approve',
            now()->addMonth(),
            ['testimonial' => $this],
        );
    }

    public function rejectUrl(): string
    {
        return URL::temporarySignedRoute(
            'testimonial.reject',
            now()->addMonth(),
            ['testimonial' => $this],
        );
    }
}
