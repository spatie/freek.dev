<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'admin' => 'boolean',
    ];

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function submittedPosts(): HasMany
    {
        return $this->hasMany(Post::class, 'submitted_by_user_id');
    }
}
