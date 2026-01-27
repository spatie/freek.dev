<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'How to use Laravel Folio for file-based routing',
            'Understanding Livewire 4 property binding',
            'A deep dive into PHP 8.4 property hooks',
            'Building real-time features with Laravel Reverb',
            'Testing Laravel applications with Pest',
            'Using Tailwind CSS utilities effectively',
            'Laravel Horizon: monitoring queued jobs',
            'Optimizing database queries with Eloquent',
            'Creating custom Artisan commands',
            'Working with Laravel collections',
            'Understanding middleware in Laravel',
            'Building APIs with Laravel Sanctum',
            'Implementing search with Laravel Scout',
            'Using Laravel Pulse for application monitoring',
            'Managing file uploads with Laravel Media Library',
            'Creating reusable Blade components',
            'Understanding service containers and dependency injection',
            'Building multi-tenant applications in Laravel',
            'Using Laravel\'s new model casts',
            'Implementing feature flags in Laravel',
        ];

        $contents = [
            "Laravel's new routing system makes it incredibly easy to create pages. Instead of defining routes in a routes file, you can simply create a Blade file in the pages directory and it automatically becomes a route.\n\nThis approach feels natural and reduces the boilerplate code you need to write. Let me show you how to get started with it.",
            "One of the most powerful features is two-way data binding. It allows you to sync data between your component class and the view without writing any JavaScript.\n\nThis makes building interactive interfaces much simpler. You can create dynamic forms, live search, and real-time validation with just a few lines of PHP code.",
            "Property hooks are a game changer for encapsulating logic directly within properties. They replace the need for traditional getters and setters while providing more control over property access.\n\nYou can now define get and set hooks right on the property declaration, making your code more readable and maintainable.",
            "Real-time features used to require complex setup with WebSockets and external services. Now you can build them natively with Laravel.\n\nThis new package provides a first-party solution for broadcasting events to your frontend, making it easy to build chat applications, notifications, and live updates.",
            "Testing doesn't have to be complicated. Pest provides a beautiful, minimalist syntax that makes writing tests enjoyable.\n\nWith its expectation API and helpful plugins, you can write comprehensive test suites that are easy to read and maintain.",
            "Utility-first CSS frameworks have changed how we build user interfaces. Instead of writing custom CSS, you compose designs using pre-built classes.\n\nThis approach leads to faster development and more consistent designs. Let me share some best practices for working with utility classes.",
            "When you're processing thousands of jobs, you need visibility into what's happening. Horizon provides a beautiful dashboard for monitoring your queues.\n\nYou can see job throughput, failure rates, and processing times at a glance. It also makes it easy to retry failed jobs and configure your queue workers.",
            "N+1 query problems can kill your application's performance. Fortunately, Laravel's ORM provides tools to solve this.\n\nWith eager loading, query scopes, and the new model loading features, you can ensure your application only makes the necessary database queries.",
            "Artisan commands are perfect for automating repetitive tasks and creating CLI tools for your application.\n\nCreating custom commands is straightforward, and they integrate seamlessly with Laravel's scheduler for running tasks on a cron-like schedule.",
            "Collections provide a fluent, convenient wrapper for working with arrays of data. They offer dozens of helpful methods for manipulating data.\n\nFrom filtering and mapping to reducing and grouping, collections make complex data transformations simple and readable.",
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'text' => $this->faker->randomElement($contents),
            'publish_date' => $this->faker->boolean(50) ? $this->faker->dateTimeBetween('-5 years') : null,
            'published' => true,
            'original_content' => $this->faker->boolean(10),
        ];
    }
}
