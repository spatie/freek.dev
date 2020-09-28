<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpgradeMailcoachTablesToV3 extends Migration
{
    public function up()
    {
        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->timestamp('all_jobs_added_to_batch_at')->nullable();
            $table->string('reply_to_email')->nullable();
            $table->string('reply_to_name')->nullable();
        });

        Schema::table('mailcoach_subscribers', function (Blueprint $table) {
            $table->uuid('imported_via_import_uuid')->nullable();
        });

        Schema::table('mailcoach_subscriber_imports', function (Blueprint $table) {
            $table->boolean('subscribe_unsubscribed')->default(false);
            $table->boolean('unsubscribe_others')->default(false);
        });

        Schema::table('mailcoach_email_lists', function (Blueprint $table) {
            $table->string('default_reply_to_email')->nullable();
            $table->string('default_reply_to_name')->nullable();
            $table->text('allowed_form_extra_attributes')->nullable();
        });

        Schema::table('mailcoach_sends', function (Blueprint $table) {
            $table->index('uuid');
        });

        Schema::table('webhook_calls', function (Blueprint $table) {
            $table->string('external_id')->nullable();
            $table->index('external_id');
        });
    }
}
