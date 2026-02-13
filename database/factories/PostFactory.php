<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Another new Spatie package drops: spatie/laravel-screenshot',
            'Laravel Permission v7 has been launched',
            'Laravel PDF v2 has been released: adds support for Laravel Cloud and easy queuing',
            'Introducing Ray 3.0',
            'I built a native mobile word game in two weeks',
            'Introducing Spatie Guidelines for Laravel Boost',
            'How to automatically generate a commit message using Claude',
            'A practical guide to event sourcing in Laravel',
            'Handling media in a Laravel application',
            'Building multi-tenant applications in Laravel',
            'How to use actions in Laravel applications',
            'Understanding Livewire lifecycle hooks',
            'Optimizing N+1 queries in large Laravel apps',
            'Building a real-time dashboard powered by Livewire',
            'Creating custom Artisan commands that actually help',
            'Why we use data transfer objects in PHP',
            'Managing file uploads with spatie/laravel-medialibrary',
            'Implementing webhook handling in Laravel',
            'How we structure large Laravel applications at Spatie',
            'Testing complex Eloquent queries with Pest',
        ];

        $contents = [
            "We just released a new package that takes screenshots of web pages in Laravel apps. It uses a driver-based architecture, so you can choose between Browsershot and Cloudflare Browser Rendering.\n\nLet me walk you through the package.",
            "Our Laravel Permission package can help you dynamically create roles and permissions. We just released v7 which cleans up the internal code and modernizes it.\n\nLet me walk you through what the package can do.",
            "A while ago, we released laravel-pdf, a package to generate PDFs in Laravel apps. Under the hood, it used Browsershot to convert HTML to PDF.\n\nThe package now ships with three drivers: Browsershot, Cloudflare Browser Rendering, and DOMPDF. You can also create your own driver.",
            'Ray 3.0 is here! Completely rebuilt for better performance (60% less memory), a fresh new look, message archiving, and MCP support so AI agents can interact with Ray directly.',
            "I got curious: how far could I push AI-assisted development? Could I actually create a whole mobile game? After about 10 days, WordStockt is a fully functional word game that's 98% vibe-coded.",
            "If you're using AI tools like Claude Code to help write code, you've probably noticed they don't automatically know your team's coding conventions. That's the problem Laravel Boost solves.",
            'For years, my git history contains "wip" commit messages. Now, I have a bash function in my dotfiles that uses Claude to generate commit messages for me.',
            "In an event sourced app you're storing each event that happens within your app and derive all state from those events. In this practical post you'll get an intro on what event sourcing is and what the benefits are.",
            "In most CMS kind of projects you're going to let a user upload all sorts of images and files. Luckily laravel-medialibrary can do all that for you.",
            "Multi-tenancy is a common requirement for SaaS applications. In this post, we'll explore different approaches to implementing multitenancy in Laravel using our laravel-multitenancy package.",
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'text' => $this->faker->randomElement($contents),
            'publish_date' => $this->faker->boolean(50) ? $this->faker->dateTimeBetween('-1 year') : null,
            'published' => true,
            'original_content' => $this->faker->boolean(10),
            'send_automated_tweet' => false,
        ];
    }
}
