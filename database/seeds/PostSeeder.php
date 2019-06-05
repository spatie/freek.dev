<?php

use Illuminate\Database\Seeder;
use Tests\Factories\PostFactory;

class PostSeeder extends Seeder
{
    public function run()
    {
        (new PostFactory(10))->tweet()->create();
        (new PostFactory(10))->original()->create();
        (new PostFactory(10))->link()->create();
    }
}
