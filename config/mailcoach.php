<?php

return [

    /*
     * The date format used on all screens of the UI
     */
    'date_format' => 'Y-m-d H:i',

    /*
     * Here you can specify which jobs should run on which queues.
     * Use an empty string to use the default queue.
     */
    'perform_on_queue' => [
        'calculate_statistics_job' => 'mailcoach',
        'send_campaign_job' => 'send-campaign',
        'send_mail_job' => 'send-mail',
        'send_test_mail_job' => 'mailcoach',
        'process_feedback_job' => 'mailcoach-feedback'
    ],

    /*
     * By default only 5 mails per second will be sent to avoid overwhelming your
     * e-mail sending service. To use this feature you must have Redis installed.
     */
    'throttling' => [
        'enabled' => true,
        'redis_connection_name' => 'default',
        'redis_key' => 'laravel-mailcoach',
        'allowed_number_of_jobs_in_timespan' => 10,
        'timespan_in_seconds' => 1,
        'release_in_seconds' => 5,
    ],

    /*
     * You can customize some of the behavior of this package by using our own custom action.
     * Your custom action should always extend the one of the default ones.
     */
    'actions' => [

        /*
         * Actions concerning campaigns
         */
        'calculate_statistics' => \Spatie\Mailcoach\Actions\Campaigns\CalculateStatisticsAction::class,
        'convert_html_to_text' => \Spatie\Mailcoach\Actions\Campaigns\ConvertHtmlToTextAction::class,
        'personalize_html' => \Spatie\Mailcoach\Actions\Campaigns\PersonalizeHtmlAction::class,
        'prepare_email_html' => \Spatie\Mailcoach\Actions\Campaigns\PrepareEmailHtmlAction::class,
        'prepare_webview_html' => \Spatie\Mailcoach\Actions\Campaigns\PrepareWebviewHtmlAction::class,
        'retry_sending_failed_sends' => \Spatie\Mailcoach\Actions\Campaigns\RetrySendingFailedSendsAction::class,
        'send_campaign' => \Spatie\Mailcoach\Actions\Campaigns\SendCampaignAction::class,
        'send_mail' => \Spatie\Mailcoach\Actions\Campaigns\SendMailAction::class,
        'send_test_mail' => \Spatie\Mailcoach\Actions\Campaigns\SendTestMailAction::class,

        /*
         * Actions concerning subscribers
         */
        'confirm_subscriber' => \Spatie\Mailcoach\Actions\Subscribers\ConfirmSubscriberAction::class,
        'create_subscriber' => \Spatie\Mailcoach\Actions\Subscribers\CreateSubscriberAction::class,
        'import_subscribers' => \Spatie\Mailcoach\Actions\Subscribers\ImportSubscribersAction::class,
        'send_confirm_subscriber_mail' => \Spatie\Mailcoach\Actions\Subscribers\SendConfirmSubscriberMailAction::class,
        'send_welcome_mail' => \Spatie\Mailcoach\Actions\Subscribers\SendWelcomeMailAction::class,
        'update_subscriber' => \Spatie\Mailcoach\Actions\Subscribers\UpdateSubscriberAction::class,
    ],
];
