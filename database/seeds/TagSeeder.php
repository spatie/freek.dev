<?php

use Illuminate\Database\Seeder;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        factory(Tag::class, 20)->create();
    }
}
