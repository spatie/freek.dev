<?php

namespace App\Models;

use App\Models\Presenters\TalkPresenter;

class Talk extends BaseModel
{
    use TalkPresenter;

    public $dates = ['presented_at'];
}
