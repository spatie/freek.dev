<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterCampaign extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'edition_number' => 'integer',
        ];
    }

    public function url(): Attribute
    {
        return new Attribute(function () {
            return route('newsletter.archive.show', $this->slug);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
