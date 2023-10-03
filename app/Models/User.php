<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Comments\Models\Concerns\InteractsWithComments;
use Spatie\Comments\Models\Concerns\Interfaces\CanComment;

class User extends Authenticatable implements CanComment, FilamentUser, MustVerifyEmail
{
    use HasFactory;
    use InteractsWithComments;
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

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->email === 'freek@spatie.be';
    }
}
