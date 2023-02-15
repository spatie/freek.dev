<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Schema::drop('mailcoach_automation_action_subscriber');
        Schema::drop('mailcoach_automation_actions');
        Schema::drop('mailcoach_automation_mail_clicks');
        Schema::drop('mailcoach_automation_mail_links');
        Schema::drop('mailcoach_automation_mail_opens');
        Schema::drop('mailcoach_automation_mail_unsubscribes');
        Schema::drop('mailcoach_automation_mails');
        Schema::drop('mailcoach_automation_triggers');
        Schema::drop('mailcoach_automations');
        Schema::drop('mailcoach_campaign_clicks');
        Schema::drop('mailcoach_campaign_links');
        Schema::drop('mailcoach_campaign_opens');
        Schema::drop('mailcoach_campaign_unsubscribes');
        Schema::drop('mailcoach_campaigns');
        Schema::drop('mailcoach_email_list_allow_form_subscription_tags');
        Schema::drop('mailcoach_email_list_subscriber_tags');
        Schema::drop('mailcoach_email_lists');
        Schema::drop('mailcoach_negative_segment_tags');
        Schema::drop('mailcoach_positive_segment_tags');
        Schema::drop('mailcoach_segments');
        Schema::drop('mailcoach_send_feedback_items');
        Schema::drop('mailcoach_sends');
        Schema::drop('mailcoach_subscriber_imports');
        Schema::drop('mailcoach_subscribers');
        Schema::drop('mailcoach_tags');
        Schema::drop('mailcoach_templates');
        Schema::drop('mailcoach_transactional_mail_clicks');
        Schema::drop('mailcoach_transactional_mail_opens');
        Schema::drop('mailcoach_transactional_mail_templates');
        Schema::drop('mailcoach_transactional_mails');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
