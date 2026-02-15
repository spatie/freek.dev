<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reaction extends Model
{
    use HasFactory;

    public function commenter(): BelongsTo
    {
        return $this->belongsTo(Commenter::class);
    }

    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }
}
