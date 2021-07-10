<?php

namespace App\Models;

use App\Services\CommonMark\CommonMark;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public static function booted()
    {
        static::saved(function (Video $ad) {
            static::withoutEvents(function () use ($ad) {
                $ad->update(['html' => CommonMark::convertToHtml($ad->text, false)]);
            });
        });
    }
}
