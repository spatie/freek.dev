<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Presenters\TalkPresenter;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use HasFactory;

    use TalkPresenter;

    public $dates = ['presented_at'];
}
