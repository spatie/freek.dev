<?php

return [

    /*
     * Here you can specify which jobs should run on which queues.
     * Use an empty string to use the default queue.
     */
    'perform_on_queue' => [
        'calculate_statistics_job' => 'calculate-statistics',
        'register_click_job' => 'register-clicks',
        'register_open_job' => 'register-opens',
        'send_campaign_job' => 'send-campaign',
        'send_mail_job' => 'send-mail',
        'send_test_mail_job' => 'send-test-mail',
    ],

    /*
     * By default only 5 mails per second will be sent to avoid overwhelming your
     * e-mail sending service. To use this feature you must have Redis installed.
     */
    'throttling' => [
        'enabled' => false,
        'redis_connection_name' => 'default',
        'redis_key' => 'laravel-email-campaigns',
        'allowed_number_of_jobs_in_timespan' => 5,
        'timespan_in_seconds' => 1,
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
        'subscribe_action' => \Spatie\Mailcoach\Actions\SubscribeAction::class,
        'confirm_subscription_action' => \Spatie\Mailcoach\Actions\ConfirmSubscriptionAction::class,
    ],
];
