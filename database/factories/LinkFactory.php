<?php

namespace Database\Factories;

use App\Enums\LinkStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    public function definition(): array
    {
        $status = $this->faker->randomElement([
            LinkStatus::Submitted,
            LinkStatus::Approved,
            LinkStatus::Rejected,
        ]);

        $links = [
            [
                'title' => 'Laravel 12 is now available',
                'url' => 'https://laravel-news.com/laravel-12',
                'text' => 'The latest version of Laravel brings exciting new features including improved performance and developer experience enhancements.',
            ],
            [
                'title' => 'Building modern frontends with Inertia.js',
                'url' => 'https://inertiajs.com',
                'text' => 'Inertia allows you to build single-page applications using classic server-side routing and controllers.',
            ],
            [
                'title' => 'Pest 4.0 released with new testing features',
                'url' => 'https://pestphp.com',
                'text' => 'The latest version of Pest brings architectural testing, better mutation testing, and improved performance.',
            ],
            [
                'title' => 'Understanding PHP 8.4 asymmetric visibility',
                'url' => 'https://stitcher.io/blog/php-84-asymmetric-visibility',
                'text' => 'Property hooks and asymmetric visibility make PHP classes more expressive and safer.',
            ],
            [
                'title' => 'Deploying Laravel with FrankenPHP',
                'url' => 'https://frankenphp.dev',
                'text' => 'FrankenPHP provides a modern application server for PHP with support for HTTP/2, HTTP/3, and real-time features.',
            ],
            [
                'title' => 'Filament 5: Admin panels made easy',
                'url' => 'https://filamentphp.com',
                'text' => 'Build beautiful admin panels with minimal code using this powerful TALL stack framework.',
            ],
            [
                'title' => 'Real-time Laravel applications with Reverb',
                'url' => 'https://reverb.laravel.com',
                'text' => 'Laravel Reverb is a blazing fast WebSocket server for Laravel applications.',
            ],
            [
                'title' => 'Alpine.js v3 petite build',
                'url' => 'https://alpinejs.dev',
                'text' => 'The minimal version of Alpine.js provides reactive and declarative JavaScript for just 7kb.',
            ],
        ];

        $link = $this->faker->randomElement($links);

        return [
            'user_id' => User::factory(),
            'title' => $link['title'],
            'url' => $link['url'],
            'text' => $link['text'],
            'status' => $status,
            'publish_date' => $status === LinkStatus::Approved ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
        ];
    }
}
