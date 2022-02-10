<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->dropColumn('send_batch_id');
            $table->dropColumn('all_jobs_added_to_batch_at');
            $table->timestamp('all_sends_created_at')->nullable();
            $table->timestamp('all_sends_dispatched_at')->nullable();
        });

        Schema::table('mailcoach_email_lists', function(Blueprint $table) {
            $table->string('automation_mailer')->after('campaign_mailer')->nullable();
        });

        Schema::table('mailcoach_sends', function (Blueprint $table) {
            $table->timestamp('sending_job_dispatched_at')->nullable();
        });

        Schema::table('mailcoach_automation_action_subscriber', function (Blueprint $table) {
            $table->timestamp('job_dispatched_at')->nullable();
        });
    }
};
