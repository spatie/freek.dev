<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Mailcoach\Enums\CampaignStatus;
use Spatie\Mailcoach\Models\Campaign;
use Spatie\Mailcoach\Models\EmailList;

class ImportSendyCampaigns extends Command
{
    protected $signature = 'import-sendy-campaigns';

    public function handle()
    {
        $emailList = EmailList::firstOrCreate(['name' => 'freek.dev newsletter']);

        DB::table('old_campaigns')->orderBy('id')->each(function (object $row) use ($emailList) {
            $sentAt = Carbon::createFromTimestamp($row->sent);

            Campaign::create([
               'email_list_id' => $emailList->id,
                'name' => $row->title,
                'subject' => $row->title,
                'last_modified_at' => $sentAt,
                'sent_at' => $sentAt,
                'html' => $row->html_text,
                'webview_html' => $row->html_text,
                'status' => CampaignStatus::SENT,
                'sent_to_number_of_subscribers' => $row->recipients,
            ]);
        });

        $this->info('All done!');
    }
}
