<?php

use App\Models\Link;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    public function run()
    {
        Link::factory()->times(50)->create();
    }
}
