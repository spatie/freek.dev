<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailCoachTables extends Migration
{
    public function up()
    {
        Schema::create('email_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('name');
            $table->boolean('requires_double_opt_in')->default(false);

            $table->string('redirect_after_already_subscribed')->nullable();
            $table->string('redirect_after_pending')->nullable();
            $table->string('redirect_after_subscribed')->nullable();

            $table->timestamps();
        });

        Schema::create('email_list_subscribers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->json('extra_attributes')->nullable();
            $table->uuid('uuid');
            $table->nullableTimestamps();
        });

        Schema::create('email_list_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('email_list_id');
            $table->unsignedBigInteger('email_list_subscriber_id');
            $table->string('status');
            $table->timestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('email_lists')
                ->onDelete('cascade');

            $table
                ->foreign('email_list_subscriber_id')
                ->references('id')->on('email_list_subscribers')
                ->onDelete('cascade');
        });

        Schema::create('email_campaigns', function (Blueprint $table) {
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
            $table->string('segment_class')->nullable();

            $table->boolean('track_opens')->default(false);
            $table->boolean('track_clicks')->default(false);

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

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('statistics_calculated_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();

            $table->timestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('email_lists')
                ->onDelete('set null');
        });

        Schema::create('campaign_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->unsignedBigInteger('email_campaign_id');
            $table->string('original_link');
            $table->integer('click_count')->default(0);
            $table->integer('unique_click_count')->default(0);
            $table->nullableTimestamps();

            $table
                ->foreign('email_campaign_id')
                ->references('id')->on('email_campaigns')
                ->onDelete('cascade');
        });

        Schema::create('campaign_sends', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('transport_message_id')->nullable();
            $table->unsignedBigInteger('email_campaign_id');
            $table->unsignedBigInteger('email_list_subscription_id');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table
                ->foreign('email_campaign_id')
                ->references('id')->on('email_campaigns')
                ->onDelete('cascade');

            $table
                ->foreign('email_list_subscription_id')
                ->references('id')->on('email_list_subscriptions')
                ->onDelete('cascade');
        });

        Schema::create('campaign_clicks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('campaign_send_id');
            $table->unsignedBigInteger('campaign_link_id');
            $table->unsignedBigInteger('email_list_subscriber_id')->nullable();
            $table->nullableTimestamps();

            $table
                ->foreign('campaign_send_id')
                ->references('id')->on('campaign_sends')
                ->onDelete('cascade');

            $table
                ->foreign('campaign_link_id')
                ->references('id')->on('campaign_links')
                ->onDelete('cascade');

            $table
                ->foreign('email_list_subscriber_id')
                ->references('id')->on('email_list_subscribers')
                ->onDelete('set null');
        });

        Schema::create('campaign_opens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_send_id');

            $table->unsignedBigInteger('email_campaign_id');
            $table->unsignedBigInteger('email_list_subscriber_id')->nullable();
            $table->nullableTimestamps();

            $table
                ->foreign('campaign_send_id')
                ->references('id')->on('campaign_sends')
                ->onDelete('cascade');

            $table
                ->foreign('email_campaign_id')
                ->references('id')->on('email_campaigns')
                ->onDelete('cascade');

            $table
                ->foreign('email_list_subscriber_id')
                ->references('id')->on('email_list_subscribers')
                ->onDelete('set null');
        });

        Schema::create('campaign_unsubscribes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('email_campaign_id');
            $table->unsignedBigInteger('email_list_subscriber_id');
            $table->timestamps();

            $table
                ->foreign('email_campaign_id')
                ->references('id')->on('email_campaigns')
                ->onDelete('cascade');

            $table
                ->foreign('email_list_subscriber_id')
                ->references('id')->on('email_list_subscribers')
                ->onDelete('cascade');
        });

        Schema::create('campaign_send_bounces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_send_id');
            $table->string('severity')->nullable();
            $table->timestamps();

            $table
                ->foreign('campaign_send_id')
                ->references('id')->on('campaign_sends')
                ->onDelete('cascade');
        });

        Schema::create('templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('html');
            $table->timestamps();
        });

        Schema::create('subscriber_imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->unsignedBigInteger('email_list_id');
            $table->integer('imported_subscribers_count')->default(0);
            $table->integer('error_count')->default(0);
            $table->timestamps();

            $table
                ->foreign('email_list_id')
                ->references('id')->on('email_lists')
                ->onDelete('cascade');
        });
    }
}
