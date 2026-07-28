<?php

namespace App\Models;

use App\Services\CommonMark\CommonMark;
use App\Services\Utm\UtmParameters;
use App\Services\Utm\UtmTagger;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public function htmlWithUtm(): Attribute
    {
        return new Attribute(function () {
            return UtmTagger::tagHtml($this->html ?? '', UtmParameters::forVideo($this));
        });
    }
}
