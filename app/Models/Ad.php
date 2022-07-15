<?php

namespace App\Models;

use App\Services\CommonMark\CommonMark;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ad extends Model
{
    use HasFactory;

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public static function getForCurrentPage(): ?self
    {
        return Ad::getForPage(request()->path());
    }

    public static function booted()
    {
        static::saved(function (Ad $ad) {
            static::withoutEvents(function () use ($ad) {
                $ad->update(['html' => CommonMark::convertToHtml($ad->text, false)]);
            });
        });
    }

    public static function getForPage(string $url = ''): ?self
    {
        return static::getPageSpecificAd($url) ?? static::getSiteWideAd();
    }

    public static function getPageSpecificAd(string $url): ?self
    {
        return static::current()
            ->where('display_on_url', $url)
            ->first();
    }

    public static function getSiteWideAd(): ?self
    {
        return static::current()
            ->where(function (Builder $query) {
                $query
                    ->where('display_on_url', '')
                    ->orWhereNull('display_on_url');
            })
            ->first();
    }

    public function scopeCurrent(Builder $query)
    {
        $now = now()->format('Y-m-d');

        $query
            ->whereDate('starts_at', '<=', $now)
            ->whereDate('ends_at', '>=', $now);
    }

    public function getFormattedTextAttribute()
    {
        return CommonMark::convertToHtml($this->text);
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->text);
    }
}
