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
        'calculate_statistics_job' => '',
        'send_campaign_job' => '',
        'send_mail_job' => '',
        'send_test_mail_job' => '',
    ],

    /*
     * By default only 5 mails per second will be sent to avoid overwhelming your
     * e-mail sending service. To use this feature you must have Redis installed.
     */
    'throttling' => [
        'enabled' => true,
        'redis_connection_name' => 'default',
        'redis_key' => 'laravel-mailcoach',
        'allowed_number_of_jobs_in_timespan' => 3,
        'timespan_in_seconds' => 4,
        'release_in_seconds' => 5,
    ],

    /*
       * You can customize some of the behavior of this package by using our own custom action.
       * Your custom action should always extend the one of the default ones.
       */
    'actions' => [
        'personalize_html_action' => \Spatie\Mailcoach\Actions\PersonalizeHtmlAction::class,
        'prepare_email_html_action' => \Spatie\Mailcoach\Actions\PrepareEmailHtmlAction::class,
        'prepare_webview_html_action' => \Spatie\Mailcoach\Actions\PrepareWebviewHtmlAction::class,
        'create_subscriber_action' => \Spatie\Mailcoach\Actions\CreateSubscriberAction::class,
        'confirm_subscription_action' => \Spatie\Mailcoach\Actions\ConfirmSubscriptionAction::class,
        'convert_html_to_text' => \Spatie\Mailcoach\Actions\ConvertHtmlToTextAction::class,
        'send_welcome_mail_action' => \Spatie\Mailcoach\Actions\SendWelcomeMailAction::class,
    ],

    'mailgun_feedback' => [
        'signing_secret' => env('MAILGUN_SIGNING_SECRET'),
    ],
];
