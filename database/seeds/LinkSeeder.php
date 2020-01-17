<?php

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    public function run()
    {
        factory(Link::class, 50)->create();
    }
}
