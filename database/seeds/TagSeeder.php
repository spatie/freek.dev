<?php

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        Tag::factory()->times(20)->create();
    }
}
