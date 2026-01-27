<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Tags\Tag;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        $tags = [
            'laravel',
            'php',
            'javascript',
            'testing',
            'livewire',
            'tailwindcss',
            'eloquent',
            'vue',
            'react',
            'pest',
            'phpunit',
            'api',
            'security',
            'performance',
            'architecture',
            'design-patterns',
            'packages',
            'tips',
            'tutorial',
            'best-practices',
        ];

        return [
            'name' => $this->faker->randomElement($tags),
        ];
    }
}
