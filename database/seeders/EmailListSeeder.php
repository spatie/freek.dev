<?php

namespace Database\Seeders;

use App\Mail\WelcomeMail;
use Illuminate\Database\Seeder;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;
use Spatie\Mailcoach\Domain\Campaign\Enums\CampaignStatus;
use Spatie\Mailcoach\Domain\Campaign\Models\Campaign;
use Spatie\Mailcoach\Domain\Campaign\Models\Template;

class EmailListSeeder extends Seeder
{
    public function run()
    {
        $emailList = EmailList::create([
            'name' => 'freek.dev newsletter',
            'requires_confirmation' => true,
            'default_from_email' => 'freek@spatie.be',
            'default_from_name' => 'Freek Van der Herten',
            'welcome_mailable_class' => WelcomeMail::class,
            'send_welcome_mail' => true,
        ]);

        foreach (range(1, 10) as $i) {
            Subscriber::createWithEmail("freek+test{$i}@spatie.be")
                ->skipConfirmation()
                ->doNotSendWelcomeMail()
                ->subscribeTo($emailList);
        }

        Template::create([
            'name' => 'Spatie',
            'html' => <<<'HTML'
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

        Campaign::create([
            'name' => 'My campaign',
            'subject' => 'subject',
            'from_email' => 'freek@spatie.be',
            'from_name' => 'Freek',
            'html' => Template::first()->html,
            'email_html' => Template::first()->html,
            'track_opens' => true,
            'track_clicks' => true,
            'status' => CampaignStatus::SENT,
            'uuid' => 'fake-uuid',
            'last_modified_at' => now(),
            'sent_at' => now(),
            'email_list_id' => $emailList->id,
        ]);

        Template::create([
            'name' => 'My template',
            'html' => '<html>
    <body>
        <a href="::webViewUrl::">Cannot read this email? See it in your browser.</a>

        <!-- insert content here -->

        <a href="::unsubscribeUrl::">Click here to unsubscribe</a>
    </body>
</html>',
        ]);

        EmailList::create([
            'name' => 'automation list',
            'requires_confirmation' => false,
            'default_from_email' => 'freek@spatie.be',
            'default_from_name' => 'Freek Van der Herten',
            'welcome_mailable_class' => WelcomeMail::class,
            'send_welcome_mail' => true,
        ]);
    }
}
