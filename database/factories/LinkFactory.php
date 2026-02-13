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
                'title' => 'Running PHP 8.5 with Laravel Octane and FrankenPHP',
                'url' => 'https://danielpetrica.com/running-php-8-5-with-laravel-octane-and-frankenphp',
                'text' => 'A quick but essential fix for anyone pushing the edges of the Laravel ecosystem. The default FrankenPHP binary is locked to PHP 8.4.',
            ],
            [
                'title' => 'From dd() to Ray: A Debugging Workflow That Doesn\'t Break Your Flow',
                'url' => 'https://tnakov.dev/from-dd-to-ray-debugging-workflow',
                'text' => 'Evolving from dd() to Ray for a smoother workflow. Explore how Ray can boost your debugging game!',
            ],
            [
                'title' => 'New in Parental v1.5.0: Becoming, Integers, and Eager-Loading',
                'url' => 'https://tighten.com/insights/new-parental-features-v1-5-0/',
                'text' => 'Version v1.5.0 of Parental adds support for Single Table Inheritance type transformations and new helper methods.',
            ],
            [
                'title' => 'Laravel Herd for Linux is here',
                'url' => 'https://herd.laravel.com',
                'text' => 'Laravel Herd is now available for Linux. One click PHP development environments with zero configuration.',
            ],
            [
                'title' => 'Building a SaaS with Laravel and Stripe',
                'url' => 'https://laravel-news.com/building-saas-stripe',
                'text' => 'A comprehensive guide to integrating Stripe into your Laravel SaaS application.',
            ],
            [
                'title' => 'SQL performance: automatic detection & regression testing',
                'url' => 'https://ohdear.app/news-and-updates/sql-performance-improvements',
                'text' => 'Mattias introduces phpunit-query-count-assertions, a package that catches N+1 queries and missing indexes in your test suite.',
            ],
            [
                'title' => 'A practical guide to PHP generics with PHPStan',
                'url' => 'https://phpstan.org/blog/generics-in-php-using-phpdocs',
                'text' => 'Learn how to use PHPDoc generics with PHPStan for better type safety in your PHP applications.',
            ],
            [
                'title' => 'Deploying Laravel with Kamal and Docker',
                'url' => 'https://laravel-news.com/deploying-laravel-kamal',
                'text' => 'How to deploy your Laravel application using Kamal, a simple deployment tool from Basecamp.',
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
