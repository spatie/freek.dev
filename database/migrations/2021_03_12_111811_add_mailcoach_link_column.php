<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMailcoachLinkColumn extends Migration
{
    public function up()
    {
        Schema::table('mailcoach_automation_mail_clicks', function (Blueprint $table) {

            $table->foreignId('automation_mail_link_id')->constrained('mailcoach_automation_mail_links');
        });
    }
}
