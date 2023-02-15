<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mailcoach_campaigns', function (Blueprint $table) {
            $table->boolean('utm_tags')->default(false)->after('track_clicks');
        });

        Schema::table('mailcoach_subscribers', function (Blueprint $table) {
            $table->index(['email_list_id', 'created_at'], 'email_list_id_created_at');
        });

        Schema::create('mailcoach_transactional_mails', function (Blueprint $table) {
            $table->id();

            $table->text('subject');

            $table->json('from');
            $table->json('to');
            $table->json('cc')->nullable();
            $table->json('bcc')->nullable();
            $table->longText('body')->nullable();

            $table->boolean('track_opens')->default(false);
            $table->boolean('track_clicks')->default(false);

            $table->string('mailable_class');

            $table->timestamps();
        });

        Schema::create('mailcoach_automation_mails', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->uuid('uuid');

            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();

            $table->string('reply_to_email')->nullable();
            $table->string('reply_to_name')->nullable();

            $table->string('subject')->nullable();

            $table->longText('html')->nullable();
            $table->longText('structured_html')->nullable();
            $table->longText('email_html')->nullable();
            $table->longText('webview_html')->nullable();

            $table->string('mailable_class')->nullable();
            $table->json('mailable_arguments')->nullable();

            $table->boolean('track_opens')->default(false);
            $table->boolean('track_clicks')->default(false);
            $table->boolean('utm_tags')->default(false);

            $table->integer('sent_to_number_of_subscribers')->default(0);
            $table->integer('open_count')->default(0);
            $table->integer('unique_open_count')->default(0);
            $table->integer('open_rate')->default(0);
            $table->integer('click_count')->default(0);
            $table->integer('unique_click_count')->default(0);
            $table->integer('click_rate')->default(0);
            $table->integer('unsubscribe_count')->default(0);
            $table->integer('unsubscribe_rate')->default(0);
            $table->integer('bounce_count')->default(0);
            $table->integer('bounce_rate')->default(0);
            $table->timestamp('statistics_calculated_at')->nullable();

            $table->timestamp('last_modified_at')->nullable();
            $table->timestamps();
        });

        Schema::table('mailcoach_sends', function (Blueprint $table) {
            $table
                ->foreignId('automation_mail_id')
                ->nullable()
                ->constrained('mailcoach_automation_mails')
                ->cascadeOnDelete()
                ->after('campaign_id');

            $table
                ->foreignId('transactional_mail_id')
                ->nullable()
                ->constrained('mailcoach_transactional_mails')
                ->cascadeOnDelete()
                ->after('automation_mail_id');
        });

        Schema::table('mailcoach_subscriber_imports', function (Blueprint $table) {
            $table->boolean('replace_tags')->default(false)->after('unsubscribe_others');
        });

        Schema::table('mailcoach_tags', function (Blueprint $table) {
            $table->string('type')->default('default')->after('name');
        });

        Schema::create('mailcoach_automations', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('email_list_id')
                ->nullable()
                ->constrained('mailcoach_email_lists')
                ->cascadeOnDelete();

            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->string('interval')->nullable();
            $table->string('status');

            $table->text('segment_class')->nullable();

            $table
                ->foreignId('segment_id')
                ->nullable()
                ->constrained('mailcoach_segments')
                ->nullOnDelete();

            $table->string('segment_description')->default(0);

            $table->timestamp('run_at')->nullable();
            $table->timestamp('last_ran_at')->nullable();

            $table->timestamps();
        });

        Schema::create('mailcoach_automation_actions', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('automation_id')
                ->nullable()
                ->constrained('mailcoach_automations')
                ->cascadeOnDelete();

            $table
                ->foreignId('parent_id')
                ->nullable()
                ->constrained('mailcoach_automation_actions')
                ->cascadeOnDelete();

            $table->uuid('uuid');
            $table->string('key')->nullable();
            $table->text('action')->nullable();
            $table->integer('order');
            $table->timestamps();
        });

        Schema::create('mailcoach_automation_triggers', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('automation_id')
                ->nullable()
                ->constrained('mailcoach_automations')
                ->cascadeOnDelete();

            $table->uuid('uuid');
            $table->text('trigger')->nullable();
            $table->timestamps();
        });

        Schema::create('mailcoach_automation_action_subscriber', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('action_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->timestamp('run_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('halted_at')->nullable();
            $table->timestamps();

            $table
                ->foreign('action_id')
                ->references('id')->on('mailcoach_automation_actions')
                ->onDelete('cascade');

            $table
                ->foreign('subscriber_id')
                ->references('id')->on('mailcoach_subscribers')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_automation_mail_opens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('send_id')->constrained('mailcoach_sends');

            $table
                ->foreignId('subscriber_id')
                ->nullable()
                ->constrained('mailcoach_subscribers')
                ->cascadeOnDelete();

            $table
                ->foreignId('automation_mail_id')
                ->nullable()
                ->constrained('mailcoach_automation_mails')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('mailcoach_automation_mail_links', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('automation_mail_id')
                ->constrained('mailcoach_automation_mails')
                ->cascadeOnDelete();

            $table->string('url', 2048);
            $table->integer('click_count')->default(0);
            $table->integer('unique_click_count')->default(0);
            $table->nullableTimestamps();
        });

        Schema::create('mailcoach_automation_mail_clicks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('send_id')->constrained('mailcoach_sends');

            $table
                ->foreignId('subscriber_id')
                ->nullable()
                ->constrained('mailcoach_subscribers')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('mailcoach_automation_mail_unsubscribes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('automation_mail_id');

            $table
                ->foreign('automation_mail_id', 'auto_unsub_automation_mail_id')
                ->references('id')->on('mailcoach_automation_mails')
                ->cascadeOnDelete();

            $table
                ->foreignId('subscriber_id')
                ->constrained('mailcoach_subscribers')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('mailcoach_transactional_mail_opens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('send_id')->constrained('mailcoach_sends');

            $table->timestamps();
        });

        Schema::create('mailcoach_transactional_mail_clicks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('send_id')->constrained('mailcoach_sends');
            $table->longText('url');

            $table->timestamps();
        });

        Schema::create('mailcoach_transactional_mail_templates', function (Blueprint $table) {
            $table->id();
            $table->json('cc')->nullable();
            $table->string('label')->nullable();
            $table->string('name');
            $table->string('subject')->nullable();
            $table->text('from')->nullable();
            $table->json('to')->nullable();
            $table->json('bcc')->nullable();
            $table->longText('body')->nullable();
            $table->string('type'); // html, blade, markdown
            $table->json('replacers')->nullable();
            $table->boolean('store_mail')->default(false);
            $table->boolean('track_opens')->default(false);
            $table->boolean('track_clicks')->default(false);
            $table->text('test_using_mailable')->nullable();
            $table->timestamps();
        });

        Schema::table('mailcoach_subscribers', function (Blueprint $table) {
            $table->index(
                [
                    'email_list_id',
                    'subscribed_at',
                    'unsubscribed_at',
                ],
                'email_list_subscribed_index'
            );
        });

        Schema::table('mailcoach_sends', function (Blueprint $table) {
            $table->unsignedBigInteger('campaign_id')->nullable()->change();
            $table->unsignedBigInteger('subscriber_id')->nullable()->change();
        });
    }
};
