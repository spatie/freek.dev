<?php


use Illuminate\Database\Seeder;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Template;

class EmailListSeeder extends Seeder
{
    public function run()
    {
        /** @var \Spatie\Mailcoach\Models\EmailList $emailList */
        $emailList = EmailList::create([
            'name' => 'freek.dev newsletter',
            'requires_double_opt_in' => true,
        ]);

        $emailList->subscribeNow('freek@spatie.be');

        Template::create([
            'name' => 'test',
            'html' => '<html><body><a href="https://spatie.be">Spatie</a></body></html>'
        ]);
    }
}
