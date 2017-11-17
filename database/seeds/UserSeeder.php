<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Freek',
            'email' => 'freek@spatie.be',
            'password' => bcrypt('freek'),
        ]);
    }
}
