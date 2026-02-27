<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsletterCampaignFactory extends Factory
{
    public function definition(): array
    {
        $editionNumber = $this->faker->unique()->numberBetween(1, 500);
        $name = "freek.dev newsletter #{$editionNumber}";
        $paragraphs = $this->faker->paragraphs(3, true);

        return [
            'mailcoach_uuid' => $this->faker->uuid(),
            'name' => $name,
            'edition_number' => $editionNumber,
            'slug' => Str::slug($name),
            'web_view_html' => "<html><body><h1>Newsletter #{$editionNumber}</h1><p>{$paragraphs}</p></body></html>",
            'sent_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
        ];
    }
}
