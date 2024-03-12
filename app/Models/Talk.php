<?php

namespace App\Models;

use App\Models\Presenters\TalkPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use HasFactory;
    use TalkPresenter;


    protected function casts(): array
    {
        return [
            'presented_at' => 'datetime',
        ];
    }
}
