<?php

use Spatie\FlareClient\Api;
use Spatie\FlareClient\AttributesProviders\ConsoleAttributesProvider;
use Spatie\FlareClient\Sampling\RateSampler;
use Spatie\LaravelFlare\AttributesProviders\LaravelRequestAttributesProvider;
use Spatie\LaravelFlare\AttributesProviders\LaravelUserAttributesProvider;
use Spatie\LaravelFlare\FlareConfig;
use Spatie\LaravelFlare\Senders\LaravelHttpSender;

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
    */
    'base_url' => env('FLARE_BASE_URL', Api::BASE_URL),

    /*
    |--------------------------------------------------------------------------
    | Collects
    |--------------------------------------------------------------------------
    |
    | Flare will collect a lot of information about your application. You can
    | disable some of the collectors here, configure them or add your own.
    |
    */

    'collects' => FlareConfig::defaultCollects(
        ignore: [],
        extra: []
    ),

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
        'console' => ConsoleAttributesProvider::class,
        'request' => LaravelRequestAttributesProvider::class,
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
        'cookies' => false,
        'session' => false,
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
    | Report error levels
    |--------------------------------------------------------------------------
    | When reporting errors, you can specify which error levels should be
    | reported. By default, all error levels are reported by setting
    | this value to `null`.
     */

    'report_error_levels' => null,

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
        'class' => LaravelHttpSender::class,
        'config' => [
            'timeout' => 10,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Trace
    |--------------------------------------------------------------------------
    |
    | Tracing allows you to see the flow of your application. It shows you
    | which parts of your application are slow and which parts are fast.
    |
    */

    'trace' => env('FLARE_TRACE', true),

    /*
    |--------------------------------------------------------------------------
    | Sampler
    |--------------------------------------------------------------------------
    |
    | The sampler is used to determine which traces should be recorded and
    | which traces should be dropped. It is possible to set the rate
    | at which traces should be recorded. The default rate is 0.1
    | which means that 10% of the traces will be recorded.
    |
    */
    'sampler' => [
        'class' => RateSampler::class,
        'config' => [
            'rate' => env('FLARE_SAMPLER_RATE', 0.1),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Trace limits
    |--------------------------------------------------------------------------
    |
    | Limits for the tracing data. These limits are used to prevent
    | the tracing data from growing too large.
    |
    */
    'trace_limits' => [
        'max_spans' => 512,
        'max_attributes_per_span' => 128,
        'max_span_events_per_span' => 128,
        'max_attributes_per_span_event' => 128,
    ],
];
