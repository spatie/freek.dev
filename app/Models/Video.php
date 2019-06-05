<?php

namespace App\Models;

use App\Services\CommonMark\CommonMark;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public function getFormattedTextAttribute()
    {
        return CommonMark::convertToHtml($this->text);
    }
}
