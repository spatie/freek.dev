<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Tests\Factories\PostFactory;

class PostSeeder extends Seeder
{
    public function run()
    {
        (new PostFactory(2))->tweet()->create();
        (new PostFactory(2))->original()->create();
        (new PostFactory(2))->link()->create();
    }
}
