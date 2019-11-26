<?php


use Illuminate\Database\Seeder;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Models\Subscriber;
use Spatie\Mailcoach\Models\Template;

class EmailListSeeder extends Seeder
{
    public function run()
    {
        /** @var \Spatie\Mailcoach\Models\EmailList $emailList */
        $emailList = EmailList::create([
            'name' => 'freek.dev newsletter',
            'requires_double_opt_in' => true,
            'default_from_email' => 'freek@spatie.be',
            'default_from_name' => 'Freek Van der Herten',
        ]);

        foreach (range(1, 10) as $i) {
            Subscriber::createWithEmail("freek+test{$i}@spatie.be")
                ->skipDoubleOptIn()
                ->subscribeTo($emailList);
        }

        Template::create([
            'name' => 'Spatie',
            'html' => '<html><body><a href="https://spatie.be">Spatie</a><br /><a href="::unsubscribeUrl::">Unsubscribe</a></body></html>'
        ]);
    }
}
