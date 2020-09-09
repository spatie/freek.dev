<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Tests\Factories\PostFactory;

class PostSeeder extends Seeder
{
    public function run()
    {
        (new PostFactory(100))->tweet()->create();
        (new PostFactory(100))->original()->create();
        (new PostFactory(100))->link()->create();
    }
}
