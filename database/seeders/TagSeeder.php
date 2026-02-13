<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Laravel',
            'PHP',
            'JavaScript',
            'AI',
            'Open Source',
            'Packages',
            'Testing',
            'Livewire',
            'Tailwind CSS',
            'Eloquent',
            'Performance',
            'Security',
            'Event Sourcing',
            'Media Library',
            'Queues',
            'Debugging',
            'Ray',
            'Flare',
            'Oh Dear',
            'Mailcoach',
        ];

        foreach ($tags as $tag) {
            Tag::findOrCreate($tag);
        }
    }
}
