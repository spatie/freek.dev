<?php

namespace Database\Seeders;

use Database\Factories\TagFactory;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        TagFactory::times(20)->create();
    }
}
