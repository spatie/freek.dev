<?php

use Spatie\LaravelFlare\AttributesProviders\LaravelUserAttributesProvider;
use Spatie\LaravelFlare\FlareConfig;

return [
    /*
    |
    |--------------------------------------------------------------------------
    | Flare API key
    |--------------------------------------------------------------------------
    |
    | Specify Flare's API key below to enable error reporting to the service.
    |
    | More info: https://flareapp.io/docs/flare/general/getting-started
    |
    */

    'key' => env('FLARE_KEY'),

    /*
    |
    |--------------------------------------------------------------------------
    | Flare Base URL
    |--------------------------------------------------------------------------
    |
    | Which server should be used to send the reports/traces to.
    |
    | Default: https://flareapp.io
    |
    */
    'base_url' => env('FLARE_BASE_URL', 'https://ingress-staging.flareapp.io'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will modify the contents of the report sent to Flare.
    |
    */

    'middleware' => [
        ...FlareConfig::defaultMiddleware(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Recorders
    |--------------------------------------------------------------------------
    |
    | These recorders, will record events that happen in your application. They
    | will be included in the error report or trace that is sent to Flare,
    | depending on the configuration.
    |
    */

    'recorders' => [
        ...FlareConfig::defaultRecorders(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Attribute providers
    |--------------------------------------------------------------------------
    |
    | When sending an error report or trace to Flare attributes can be added to
    | the report or trace for common entries. An example of such an entry is
    | the currently authenticated user. In an attribute provider you can
    | specify which attributes should be sent.
    |
    */

    'attribute_providers' => [
        'user' => LaravelUserAttributesProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Censor data
    |--------------------------------------------------------------------------
    |
    | It is possible to censor sensitive data from the reports and sent to
    | Flare. Below you can specify which fields and header should be
    | censored. It is also possible to hide the client's IP address.
    |
    */

    'censor' => [
        'body_fields' => [
            'password',
            'password_confirmation',
        ],
        'headers' => [
            'API-KEY',
            'Authorization',
            'Cookie',
            'Set-Cookie',
            'X-CSRF-TOKEN',
            'X-XSRF-TOKEN',
        ],
        'client_ips' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Reporting log statements
    |--------------------------------------------------------------------------
    |
    | If this setting is `false` log statements won't be sent as events to Flare,
    | no matter which error level you specified in the Flare log channel.
    |
    */

    'send_logs_as_events' => true,

    /*
    |--------------------------------------------------------------------------
    | Solution Providers
    |--------------------------------------------------------------------------
    |
    | List of solution providers that should be loaded. You may specify additional
    | providers as fully qualified class names.
    |
    */

    'solution_providers' => [
        ...FlareConfig::defaultSolutionProviders(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Report error levels
    |--------------------------------------------------------------------------
    | When reporting errors, you can specify which error levels should be
    | reported. By default, all error levels are reported by setting
    | this value to `null`.
     */

    'report_error_levels' => null,

    /*
   |--------------------------------------------------------------------------
   | Include arguments
   |--------------------------------------------------------------------------
   |
   | Flare show you stack traces of exceptions with the arguments that were
   | passed to each method. This feature can be disabled here.
   |
   */

    'with_stack_frame_arguments' => true,

    /*
    |--------------------------------------------------------------------------
    | Force stack frame arguments ini setting
    |--------------------------------------------------------------------------
    |
    | On some machines, the `zend.exception_ignore_args` ini setting is
    | enabled by default making it impossible to get the arguments of stack
    | frames. You can force this setting to be disabled here.
    |
    */

    'force_stack_frame_arguments_ini_setting' => true,

    /*
   |--------------------------------------------------------------------------
   | Argument reducers
   |--------------------------------------------------------------------------
   |
   | Flare show you stack traces of exceptions with the arguments that were
   | passed to each method. To make these variables more readable, you can
   | specify a list of classes here which summarize the variables.
   |
   */

    'argument_reducers' => [
        ...FlareConfig::defaultArgumentReducers(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Share button
    |--------------------------------------------------------------------------
    |
    | Flare automatically adds a Share button to the laravel error page. This
    | button allows you to easily share errors with colleagues or friends. It
    | is enabled by default, but you can disable it here.
    |
    */

    'enable_share_button' => true,

    /*
    |--------------------------------------------------------------------------
    | Override grouping
    |--------------------------------------------------------------------------
    |
    | Flare will try to group errors and exceptions as best as possible, that
    | being said, sometimes you might want to override the grouping. You can
    | do this by adding exception classes to this array which should always
    | be grouped by exception class, exception message or exception class
    | and message.
    |
    */

    'overridden_groupings' => [
        //        Illuminate\Http\Client\ConnectionException::class => Spatie\FlareClient\Enums\OverriddenGrouping::ExceptionMessageAndClass,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sender
    |--------------------------------------------------------------------------
    |
    | The sender is responsible for sending the error reports and traces to
    | Flare it can be configured if needed.
    |
    */
    'sender' => [
        'class' => \Spatie\LaravelFlare\Senders\LaravelHttpSender::class,
        'config' => [
            'timeout' => 10,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracing
    |--------------------------------------------------------------------------
    |
    | Tracing allows you to see the flow of your application. It shows you
    | which parts of your application are slow and which parts are fast.
    |
    */
    'tracing' => [
        'enabled' => true,

        // The sampler is used to determine which traces should be recorded
        'sampler' => [
            'class' => \Spatie\FlareClient\Sampling\RateSampler::class,
            'config' => [
                'rate' => 1,
            ],
        ],

        // Whether to trace throwables
        'trace_throwables' => true,

        // Limits for the tracing data
        'limits' => [
            'max_spans' => 512,
            'max_attributes_per_span' => 128,
            'max_span_events_per_span' => 128,
            'max_attributes_per_span_event' => 128,
        ],
    ],
];
