<?php

use App\Models\Newsletter;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder
{
    public function run()
    {
        factory(Newsletter::class, 10)->create();
    }
}
