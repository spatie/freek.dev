<?php

use App\Models\Talk;
use Illuminate\Database\Seeder;

class TalkSeeder extends Seeder
{
    public function run()
    {
        factory(Talk::class, 50)->create();
    }
}
