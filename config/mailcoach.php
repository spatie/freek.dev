<?php

return [
    'campaigns' => [
        /*
         * The default mailer used by Mailcoach for sending campaigns.
         */
        'mailer' => null,

        /*
         * Replacers are classes that can make replacements in the html of a campaign.
         *
         * You can use a replacer to create placeholders.
         */
        'replacers' => [
            \Spatie\Mailcoach\Domain\Campaign\Support\Replacers\WebviewCampaignReplacer::class,
            \Spatie\Mailcoach\Domain\Campaign\Support\Replacers\SubscriberReplacer::class,
            \Spatie\Mailcoach\Domain\Campaign\Support\Replacers\EmailListCampaignReplacer::class,
            \Spatie\Mailcoach\Domain\Campaign\Support\Replacers\UnsubscribeUrlReplacer::class,
            \Spatie\Mailcoach\Domain\Campaign\Support\Replacers\CampaignNameCampaignReplacer::class,
        ],

        /*
         * Here you can configure which campaign template editor Mailcoach uses.
         * By default this is a text editor that highlights HTML.
         */
        'editor' => \Spatie\MailcoachMonaco\MonacoEditor::class,

        /*
         * Here you can specify which jobs should run on which queues.
         * Use an empty string to use the default queue.
         */
        'perform_on_queue' => [
            'send_campaign_job' => 'send-campaign',
            'send_mail_job' => 'send-mail',
            'send_test_mail_job' => 'mailcoach',
            'send_welcome_mail_job' => 'mailcoach',
            'process_feedback_job' => 'mailcoach-feedback',
            'import_subscribers_job' => 'mailcoach',
        ],

        /*
         * By default only 10 mails per second will be sent to avoid overwhelming your
         * e-mail sending service. To use this feature you must have Redis installed.
         */
        'throttling' => [
            'enabled' => true,
            'redis_connection_name' => 'default',
            'redis_key' => 'laravel-mailcoach',
            'allowed_number_of_jobs_in_timespan' => 10,
            'timespan_in_seconds' => 1,
            'release_in_seconds' => 5,
            'retry_until_hours' => 24,
        ],

        /*
         * You can customize some of the behavior of this package by using our own custom action.
         * Your custom action should always extend the one of the default ones.
         */
        'actions' => [
            'prepare_email_html' => \Spatie\Mailcoach\Domain\Campaign\Actions\PrepareEmailHtmlAction::class,
            'prepare_subject' => \Spatie\Mailcoach\Domain\Campaign\Actions\PrepareSubjectAction::class,
            'prepare_webview_html' => \Spatie\Mailcoach\Domain\Campaign\Actions\PrepareWebviewHtmlAction::class,
            'convert_html_to_text' => \Spatie\Mailcoach\Domain\Campaign\Actions\ConvertHtmlToTextAction::class,
            'personalize_html' => \Spatie\Mailcoach\Domain\Campaign\Actions\PersonalizeHtmlAction::class,
            'personalize_subject' => \Spatie\Mailcoach\Domain\Campaign\Actions\PersonalizeSubjectAction::class,
            'retry_sending_failed_sends' => \Spatie\Mailcoach\Domain\Campaign\Actions\RetrySendingFailedSendsAction::class,
            'send_campaign' => \Spatie\Mailcoach\Domain\Campaign\Actions\SendCampaignAction::class,
            'send_mail' => \Spatie\Mailcoach\Domain\Campaign\Actions\SendMailAction::class,
            'send_test_mail' => \Spatie\Mailcoach\Domain\Campaign\Actions\SendCampaignTestAction::class,
        ],
    ],

    'automation' => [
        /*
         * The default mailer used by Mailcoach for automation mails.
         */
        'mailer' => null,

        /*
         * Here you can configure which automation mail template editor Mailcoach uses.
         * By default this is a text editor that highlights HTML.
         */
        'editor' => \Spatie\MailcoachMonaco\MonacoEditor::class,

        'actions' => [
            'send_mail' => \Spatie\Mailcoach\Domain\Automation\Actions\SendMailAction::class,
            'send_automation_mail_to_subscriber' => \Spatie\Mailcoach\Domain\Automation\Actions\SendAutomationMailToSubscriberAction::class,
            'prepare_subject' => \Spatie\Mailcoach\Domain\Automation\Actions\PrepareSubjectAction::class,
            'prepare_webview_html' => \Spatie\Mailcoach\Domain\Automation\Actions\PrepareWebviewHtmlAction::class,

            'convert_html_to_text' => \Spatie\Mailcoach\Domain\Automation\Actions\ConvertHtmlToTextAction::class,
            'prepare_email_html' => \Spatie\Mailcoach\Domain\Automation\Actions\PrepareEmailHtmlAction::class,
            'personalize_html' => \Spatie\Mailcoach\Domain\Automation\Actions\PersonalizeHtmlAction::class,
            'personalize_subject' => \Spatie\Mailcoach\Domain\Automation\Actions\PersonalizeSubjectAction::class,
            'send_test_mail' => \Spatie\Mailcoach\Domain\Automation\Actions\SendAutomationMailTestAction::class,

        ],

        'replacers' => [
            \Spatie\Mailcoach\Domain\Automation\Support\Replacers\WebviewAutomationMailReplacer::class,
            \Spatie\Mailcoach\Domain\Automation\Support\Replacers\SubscriberReplacer::class,
            \Spatie\Mailcoach\Domain\Automation\Support\Replacers\UnsubscribeUrlReplacer::class,
            \Spatie\Mailcoach\Domain\Automation\Support\Replacers\AutomationMailNameAutomationMailReplacer::class,
        ],

        'flows' => [
            /**
             * The available actions in the automation flows. You can add custom
             * actions to this array, make sure they extend
             * \Spatie\Mailcoach\Domain\Automation\Support\Actions\AutomationAction
             */
            'actions' => [
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\AddTagsAction::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\SendAutomationMailAction::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\ConditionAction::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\SplitAction::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\RemoveTagsAction::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\WaitAction::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\HaltAction::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Actions\UnsubscribeAction::class,
            ],

            /**
             * The available triggers in the automation settings. You can add
             * custom triggers to this array, make sure they extend
             * \Spatie\Mailcoach\Domain\Automation\Support\Triggers\AutomationTrigger
             */
            'triggers' => [
                \Spatie\Mailcoach\Domain\Automation\Support\Triggers\NoTrigger::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Triggers\SubscribedTrigger::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Triggers\DateTrigger::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Triggers\TagAddedTrigger::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Triggers\TagRemovedTrigger::class,
                \Spatie\Mailcoach\Domain\Automation\Support\Triggers\WebhookTrigger::class,
            ],

            /**
             * Custom conditions for the ConditionAction, these have to implement the
             * \Spatie\Mailcoach\Domain\Automation\Support\Conditions\Condition
             * interface.
             */
            'conditions' => []
        ],

        'perform_on_queue' => [
            'run_automation_action_job' => 'send-campaign',
            'run_action_for_subscriber_job' => 'mailcoach',
            'run_automation_for_subscriber_job' => 'mailcoach',
            'send_automation_mail_to_subscriber_job' => 'send-automation-mail',
            'send_automation_mail_job' => 'send-mail',
            'send_test_mail_job' => 'mailcoach',
        ],
    ],

    'audience' => [
        'actions' => [
            'confirm_subscriber' => \Spatie\Mailcoach\Domain\Audience\Actions\Subscribers\ConfirmSubscriberAction::class,
            'create_subscriber' => \Spatie\Mailcoach\Domain\Audience\Actions\Subscribers\CreateSubscriberAction::class,
            'delete_subscriber' => \Spatie\Mailcoach\Domain\Audience\Actions\Subscribers\DeleteSubscriberAction::class,
            'import_subscribers' => \Spatie\Mailcoach\Domain\Audience\Actions\Subscribers\ImportSubscribersAction::class,
            'send_confirm_subscriber_mail' => \Spatie\Mailcoach\Domain\Audience\Actions\Subscribers\SendConfirmSubscriberMailAction::class,
            'send_welcome_mail' => \Spatie\Mailcoach\Domain\Audience\Actions\Subscribers\SendWelcomeMailAction::class,
            'update_subscriber' => \Spatie\Mailcoach\Domain\Audience\Actions\Subscribers\UpdateSubscriberAction::class,
        ],

        /*
         * This disk will be used to store files regarding importing subscribers.
         */
        'import_subscribers_disk' => 'public',
    ],

    'transactional' => [
        /*
         * The default mailer used by Mailcoach for transactional mails.
         */
        'mailer' => null,

        /*
         * Replacers are classes that can make replacements in the body of transactional mails.
         *
         * You can use replacers to create placeholders.
         */
        'replacers' => [
            'subject' => \Spatie\Mailcoach\Domain\TransactionalMail\Support\Replacers\SubjectReplacer::class,
        ],

        'actions' => [
            'send_test' => \Spatie\Mailcoach\Domain\TransactionalMail\Actions\SendTestForTransactionalMailTemplateAction::class,
            'render_template' => \Spatie\Mailcoach\Domain\TransactionalMail\Actions\RenderTemplateAction::class,
        ],

        /**
         * Here you can configure which transactional mail template editor Mailcoach uses.
         * By default this is a text editor that highlights HTML.
         */
        'editor' => \Spatie\Mailcoach\Domain\Shared\Support\Editor\TextEditor::class,
    ],

    'shared' => [
        /*
         * Here you can specify which jobs should run on which queues.
         * Use an empty string to use the default queue.
         */
        'perform_on_queue' => [
            'calculate_statistics_job' => 'mailcoach',
        ],

        'actions' => [
            'calculate_statistics' => \Spatie\Mailcoach\Domain\Shared\Actions\CalculateStatisticsAction::class,
        ],
    ],

    /*
     * The mailer used by Mailcoach for password resets and summary emails.
     * Mailcoach will use the default Laravel mailer if this is not set.
     */
    'mailer' => null,

    /*
     * The date format used on all screens of the UI
     */
    'date_format' => 'Y-m-d H:i',

    /*
     * Here you can specify on which connection Mailcoach's jobs will be dispatched.
     * Leave empty to use the app default's env('QUEUE_CONNECTION')
     */
    'queue_connection' => '',


    /*
     * Unauthorized users will get redirected to this route.
     */
    'redirect_unauthorized_users_to_route' => 'login',

    /*
     *  This configuration option defines the authentication guard that will
     *  be used to protect your the Mailcoach UI. This option should match one
     *  of the authentication guards defined in the "auth" config file.
     */
    'guard' => env('MAILCOACH_GUARD', null),

    /*
     *  These middleware will be assigned to every Mailcoach routes, giving you the chance
     *  to add your own middleware to this stack or override any of the existing middleware.
     */
    'middleware' => [
        'web' => [
            'web',
            Spatie\Mailcoach\Http\App\Middleware\Authenticate::class,
            Spatie\Mailcoach\Http\App\Middleware\Authorize::class,
            Spatie\Mailcoach\Http\App\Middleware\SetMailcoachDefaults::class,
        ],
        'api' => [
            'api',
            'auth:api',
        ],
    ],


    'models' => [
        /*
         * The model you want to use as a Campaign model. It needs to be or
         * extend the `Spatie\Mailcoach\Domain\Campaign\Models\Campaign::class`
         * model.
         */
        'campaign' => Spatie\Mailcoach\Domain\Campaign\Models\Campaign::class,

        /*
         * The model you want to use as a EmailList model. It needs to be or
         * extend the `Spatie\Mailcoach\Domain\Audience\Models\EmailList::class`
         * model.
         */
        'email_list' => \Spatie\Mailcoach\Domain\Audience\Models\EmailList::class,

        /*
         * The model you want to use as a EmailList model. It needs to be or
         * extend the `Spatie\Mailcoach\Domain\Shared\Models\Send::class`
         * model.
         */
        'send' => \Spatie\Mailcoach\Domain\Shared\Models\Send::class,

        /*
         * The model you want to use as a Subscriber model. It needs to be or
         * extend the `Spatie\Mailcoach\Domain\Audience\Models\Subscriber::class`
         * model.
         */
        'subscriber' => \Spatie\Mailcoach\Domain\Audience\Models\Subscriber::class,

        /*
         * The model you want to use as a Template model. It needs to be or
         * extend the `Spatie\Mailcoach\Domain\Campaign\Models\Template::class`
         * model.
         */
        'template' => Spatie\Mailcoach\Domain\Campaign\Models\Template::class,

        /*
         * The model you want to use as a TransactionalMail model. It needs to be or
         * extend the `Spatie\Mailcoach\Domain\TransactionalMail\Models\TransactionalMail::class`
         * model.
         */
        'transactional_mail' => \Spatie\Mailcoach\Domain\TransactionalMail\Models\TransactionalMail::class,

        /*
         * The model you want to use as a TransactionalMailTemplate model. It needs to be or
         * extend the `\Spatie\Mailcoach\Domain\TransactionalMail\Models\TransactionalMailTemplate::class`
         * model.
         */
        'transactional_mail_template' => \Spatie\Mailcoach\Domain\TransactionalMail\Models\TransactionalMailTemplate::class,

        /*
         * The model you want to use as an Automation model. It needs to be or
         * extend the `\Spatie\Mailcoach\Domain\Automation\Models\Automation::class`
         * model.
         */
        'automation' => \Spatie\Mailcoach\Domain\Automation\Models\Automation::class,

        /*
         * The model you want to use as an Automation mail model. It needs to be or
         * extend the `\Spatie\Mailcoach\Domain\Automation\Models\AutomationMail::class` model.
         */
        'automation_mail' => \Spatie\Mailcoach\Domain\Automation\Models\AutomationMail::class,
    ],

    'views' => [
        /*
         * The service provider registers several Blade components that are
         * used in Mailcoach's views. If you are using the default Mailcoach
         * views, leave this as true so they work as expected. If you have
         * your own views and don't need/want Mailcoach to register these
         * blade components (e.g., because of naming conflicts), you can
         * change this setting to false and they won't be registered.
         *
         * If you change this setting, be sure to run `php artisan view:clear`
         * so Laravel can recompile your views.
         */
        'use_blade_components' => true,
    ],

    'mailgun_feedback' => [
        'signing_secret' => env('MAILGUN_SIGNING_SECRET'),
    ],
];
