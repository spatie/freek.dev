<?php


use Illuminate\Database\Seeder;
use Spatie\MailCoach\Models\EmailList;

class EmailListSeeder extends Seeder
{
    public function run()
    {
        EmailList::create([
            'name' => 'freek.dev newsletter',
            'requires_double_opt_in' => true,
        ]);
    }
}
