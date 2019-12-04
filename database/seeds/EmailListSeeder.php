<?php


use App\Mail\WelcomeMail;
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
            'requires_confirmation' => true,
            'default_from_email' => 'freek@spatie.be',
            'default_from_name' => 'Freek Van der Herten',
            'welcome_mailable_class' => WelcomeMail::class,
        ]);

        foreach (range(1, 5) as $i) {
            Subscriber::createWithEmail("freek+test{$i}@spatie.be")
                ->skipDoubleOptIn()
                ->subscribeTo($emailList);
        }

        Template::create([
            'name' => 'Spatie',
            'html' => <<<HTML
                        <html>
                            <body>
                                <ul>
                                    <li> <a href="https://spatie.be">Spatie</a></li>
                                    <li> <a href="https://mailcoach.app">Mailcoach</a></li>
                                    <li><a href="::unsubscribeUrl::">Unsubscribe</a>
                                </ul>
                            </body>
                        </html>
                        HTML
        ]);
    }
}
