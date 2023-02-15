<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TalkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'location' => $this->faker->city().', '.$this->faker->country(),
            'presented_at' => $this->faker->dateTimeBetween('-5 years'),
            'slides_link' => $this->faker->boolean(50) ? $this->faker->url() : '',
            'video_link' => $this->faker->boolean(50) ? $this->faker->url() : '',
            'joindin_link' => $this->faker->boolean(50) ? $this->faker->url() : '',
        ];
    }
}
