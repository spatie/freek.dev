<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Freek',
            'email' => 'freek@spatie.be',
            'password' => bcrypt('password'),
            'admin' => true,
            'email_verified_at' => now(),
        ]);

        User::factory()->count(10)->create();
    }
}
