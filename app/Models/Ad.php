<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public static function getForPage(string $url = ''): ?self
    {
        if ($ad = static::getPageSpecificAd($url)) {
            return $ad;
        }

        return static::getSiteWideAd();
    }

    public static function getPageSpecificAd(string $url): ?self
    {
        return static::current()->where('display_on_url', $url)->first();
    }

    public static function getSiteWideAd(): ?self
    {
        return static::current()->where('display_on_url', '')->first();
    }

    public function scopeCurrent(Builder $query)
    {
        $now = now()->format('Y-m-d');

        $query
            ->whereDate('starts_at', '<=', $now)
            ->whereDate('ends_at', '>=', $now);
    }
}
