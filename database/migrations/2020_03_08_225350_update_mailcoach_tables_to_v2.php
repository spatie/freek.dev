<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mailcoach_email_lists', function (Blueprint $table) {
            $table->text('confirmation_mail_content')->nullable()->change();
            $table->string('campaign_mailer')->nullable();
            $table->string('transactional_mailer')->nullable();
            $table->text('welcome_mail_content')->nullable()->change();
            $table->boolean('welcome_mail_delay_in_minutes')->default(0);
        });

        Schema::table('mailcoach_subscribers', function (Blueprint $table) {
            $table->unique(['email_list_id', 'email']);
        });

        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->longText('structured_html')->nullable();
            $table->text('segment_class')->nullable()->change();
        });

        Schema::table('mailcoach_campaign_links', function (Blueprint $table) {
            $table->string('url', 2048)->change();
        });
    }
};
