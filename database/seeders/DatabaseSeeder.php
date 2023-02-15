<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this
            ->call(UserSeeder::class)
            ->call(TagSeeder::class)
            ->call(PostSeeder::class)
            ->call(CommentSeeder::class)
            ->call(TalkSeeder::class)
            ->call(AdSeeder::class)
            ->call(VideoSeeder::class)
            ->call(WebmentionSeeder::class)
            ->call(LinkSeeder::class);
    }
}
