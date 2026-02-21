<?php

namespace Database\Factories;

use App\Models\NewsletterTestimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterTestimonialFactory extends Factory
{
    protected $model = NewsletterTestimonial::class;

    public function definition(): array
    {
        return [
            'author_name' => $this->faker->name(),
            'author_title' => $this->faker->jobTitle().' at '.$this->faker->company(),
            'author_url' => $this->faker->optional(0.5)->url(),
            'avatar_url' => 'https://i.pravatar.cc/150?u='.$this->faker->unique()->uuid(),
            'text' => $this->faker->sentence(12),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }
}
