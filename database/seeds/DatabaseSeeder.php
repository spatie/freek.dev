<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this
            ->call(UserSeeder::class)
            ->call(TagSeeder::class)
            ->call(PostSeeder::class)
            ->call(TalkSeeder::class)
            ->call(AdSeeder::class)
            ->call(VideoSeeder::class)
            ->call(WebmentionSeeder::class)
            ->call(EmailListSeeder::class)
            ->call(LinkSeeder::class);
    }
}
