<?php

namespace App\Models;

use App\Models\Presenters\TalkPresenter;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use TalkPresenter;

    public $dates = ['presented_at'];
}
