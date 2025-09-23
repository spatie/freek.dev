<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Faker\Factory as Faker;

class FlareDemoController extends Controller
{
    public function index()
    {
        $faker = Faker::create();

        $posts = collect(range(1, 12))->map(function ($i) use ($faker) {
            return (object) [
                'id' => $i,
                'title' => $faker->sentence(rand(4, 8)),
                'excerpt' => $faker->paragraph(rand(2, 4)),
                'author' => $faker->name,
                'date' => $faker->dateTimeBetween('-2 years', 'now')->format('M j, Y'),
                'reading_time' => rand(3, 15) . ' min read',
                'category' => $faker->randomElement(['Laravel', 'PHP', 'JavaScript', 'Vue.js', 'React', 'DevOps', 'Testing', 'Open Source']),
                'tags' => $faker->randomElements(['tutorial', 'tips', 'best-practices', 'performance', 'security', 'debugging', 'tools', 'packages'], rand(2, 4)),
                'views' => $faker->numberBetween(100, 10000),
                'comments' => $faker->numberBetween(0, 50),
            ];
        });

        return view('flare-demo', compact('posts'));
    }
}