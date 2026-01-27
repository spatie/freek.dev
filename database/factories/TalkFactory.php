<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TalkFactory extends Factory
{
    public function definition(): array
    {
        $talks = [
            'Laravel Beyond CRUD: Domain Driven Design in Practice',
            'Building Maintainable Laravel Applications',
            'Event Sourcing with Laravel',
            'Modern PHP: What Changed in the Last Few Years',
            'Testing Strategies for Laravel Applications',
            'Real-time Laravel with WebSockets',
            'Package Development for Laravel',
            'Advanced Eloquent Patterns and Techniques',
            'Scaling Laravel Applications',
            'The Power of Laravel Collections',
            'Building APIs with Laravel',
            'Understanding Laravel\'s Service Container',
            'Livewire: Full-stack Laravel Without JavaScript',
            'From Monolith to Microservices with Laravel',
            'Performance Optimization in Laravel',
        ];

        $conferences = [
            'Laracon US, Nashville',
            'Laracon EU, Amsterdam',
            'Laracon AU, Sydney',
            'PHP UK Conference, London',
            'SymfonyCon, Brussels',
            'PHP[TEK], Chicago',
            'International PHP Conference, Berlin',
            'DutchPHP Conference, Amsterdam',
            'Laracon India, Delhi',
            'Web Summer Camp, Rovinj',
        ];

        return [
            'title' => $this->faker->randomElement($talks),
            'location' => $this->faker->randomElement($conferences),
            'presented_at' => $this->faker->dateTimeBetween('-5 years'),
            'slides_link' => $this->faker->boolean(50) ? 'https://speakerdeck.com/freekmurze/'.str($this->faker->randomElement($talks))->slug() : '',
            'video_link' => $this->faker->boolean(50) ? 'https://youtube.com/watch?v='.str()->random(11) : '',
            'joindin_link' => $this->faker->boolean(50) ? 'https://joind.in/event/'.str()->random(8) : '',
        ];
    }
}
