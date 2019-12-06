<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailcoachTables extends Migration
{
    public function up()
    {
        Schema::create('mailcoach_email_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->string('campaigns_feed_enabled')->default(true);

            $table->string('default_from_email')->nullable();
            $table->string('default_from_name')->nullable();

            $table->boolean('allow_form_subscriptions')->default(false);

            $table->string('redirect_after_subscribed')->nullable();
            $table->string('redirect_after_already_subscribed')->nullable();
            $table->string('redirect_after_subscription_pending')->nullable();
            $table->string('redirect_after_unsubscribed')->nullable();

            $table->boolean('requires_confirmation')->default(false);
            $table->string('confirmation_mail_subject')->nullable();
            $table->string('confirmation_mail_content')->nullable();
            $table->string('confirmation_mailable_class')->nullable();

            $table->boolean('send_welcome_mail')->nullable();
            $table->string('welcome_mail_subject')->nullable();
            $table->string('welcome_mail_content')->nullable();
            $table->string('welcome_mailable_class')->nullable();

            $table->string('campaign_report_recipients')->nullable();

            $table->timestamps();
        });

        Schema::create('mailcoach_subscribers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('email_list_id');

            $table->string('email');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->json('extra_attributes')->nullable();

            $table->uuid('uuid');
            $table->timestamp('subscribed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->nullableTimestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('mailcoach_email_lists')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->uuid('uuid');
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            $table->string('subject')->nullable();

            $table->unsignedBigInteger('email_list_id')->nullable();
            $table->string('status');

            $table->longText('html')->nullable();
            $table->longText('email_html')->nullable();
            $table->longText('webview_html')->nullable();

            $table->string('mailable_class')->nullable();

            $table->boolean('track_opens')->default(false);
            $table->boolean('track_clicks')->default(false);

            $table->integer('sent_to_number_of_subscribers')->default(0);

            $table->string('segment_class')->nullable();
            $table->string('segment_description')->default(0);
            $table->boolean('segment_using_all_tags')->default(false);

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

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('statistics_calculated_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();

            $table->timestamp('last_modified_at')->nullable();

            $table->timestamp('summary_mail_sent_at')->nullable();

            $table->timestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('mailcoach_email_lists')
                ->onDelete('set null');
        });

        Schema::create('mailcoach_campaign_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_id');
            $table->string('url');
            $table->integer('click_count')->default(0);
            $table->integer('unique_click_count')->default(0);
            $table->nullableTimestamps();

            $table
                ->foreign('campaign_id')
                ->references('id')->on('mailcoach_campaigns')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_sends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('transport_message_id')->nullable();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table
                ->foreign('campaign_id')
                ->references('id')->on('mailcoach_campaigns')
                ->onDelete('cascade');

            $table
                ->foreign('subscriber_id')
                ->references('id')->on('mailcoach_subscribers')
                ->onDelete('cascade');

            $table->unique('transport_message_id');
        });

        Schema::create('mailcoach_campaign_clicks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('send_id');
            $table->unsignedBigInteger('campaign_link_id');
            $table->unsignedBigInteger('subscriber_id')->nullable();
            $table->nullableTimestamps();

            $table
                ->foreign('send_id')
                ->references('id')->on('mailcoach_sends')
                ->onDelete('cascade');

            $table
                ->foreign('campaign_link_id')
                ->references('id')->on('mailcoach_campaign_links')
                ->onDelete('cascade');

            $table
                ->foreign('subscriber_id')
                ->references('id')->on('mailcoach_subscribers')
                ->onDelete('set null');
        });

        Schema::create('mailcoach_campaign_opens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('send_id');

            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('subscriber_id')->nullable();
            $table->nullableTimestamps();

            $table
                ->foreign('send_id')
                ->references('id')->on('mailcoach_sends')
                ->onDelete('cascade');

            $table
                ->foreign('campaign_id')
                ->references('id')->on('mailcoach_campaigns')
                ->onDelete('cascade');

            $table
                ->foreign('subscriber_id')
                ->references('id')->on('mailcoach_subscribers')
                ->onDelete('set null');
        });

        Schema::create('mailcoach_campaign_unsubscribes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('subscriber_id');
            $table->timestamps();

            $table
                ->foreign('campaign_id')
                ->references('id')->on('mailcoach_campaigns')
                ->onDelete('cascade');

            $table
                ->foreign('subscriber_id')
                ->references('id')->on('mailcoach_subscribers')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_send_feedback_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->unsignedBigInteger('send_id');
            $table->json('extra_attributes')->nullable();
            $table->timestamps();

            $table
                ->foreign('send_id')
                ->references('id')->on('mailcoach_sends')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('html');
            $table->timestamps();
        });

        Schema::create('mailcoach_subscriber_imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->unsignedBigInteger('email_list_id');
            $table->integer('imported_subscribers_count')->default(0);
            $table->integer('error_count')->default(0);
            $table->timestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('mailcoach_email_lists')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('email_list_id');
            $table->timestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('mailcoach_email_lists')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_email_list_subscriber_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subscriber_id');
            $table->unsignedBigInteger('tag_id');

            $table
                ->foreign('subscriber_id')
                ->references('id')->on('mailcoach_subscribers')
                ->onDelete('cascade');

            $table
                ->foreign('tag_id')
                ->references('id')->on('mailcoach_tags')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_email_list_allow_form_subscription_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('email_list_id');
            $table->unsignedBigInteger('tag_id');

            $table
                ->foreign('email_list_id', 'email_list_tags_email_list_id_index')
                ->references('id')->on('mailcoach_email_lists')
                ->onDelete('cascade');

            $table
                ->foreign('tag_id', 'email_list_tags_tag_id_index')
                ->references('id')->on('mailcoach_tags')
                ->onDelete('cascade');
        });

        Schema::create('mailcoach_campaign_segment_tags', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('tag_id');

            $table
                ->foreign('campaign_id')
                ->references('id')->on('mailcoach_campaigns')
                ->onDelete('cascade');

            $table
                ->foreign('tag_id')
                ->references('id')->on('mailcoach_tags')
                ->onDelete('cascade');
        });
    }
}
