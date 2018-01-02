<?php

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run()
    {
        factory(Ad::class, 10)->create();
    }
}
