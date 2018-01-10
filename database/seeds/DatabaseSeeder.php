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
           ->call(AdSeeder::class);
    }
}
