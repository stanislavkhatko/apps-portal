<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "custom", "stack"
    |
    */
    'slack_alert'=> env('SLACK_ALERT',false),

    'slack_debug'=> env('SLACK_DEBUG',false),

    'slack_debug_file'=> env('SLACK_DEBUG_FILE', false),

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single','slack_debug','slack_errors'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 7,
        ],

        'slack_debug' => [
            'driver' => 'slack',
            'url' => env('SLACK_WEB_HOOK_DEBUG','http://example.com'),
            'username' => env('LOG_SLACK_USER','Server Machine'),
            'emoji' => ':speech_balloon:',
            'level' => 'debug',
        ],

        'slack_errors' => [
            'driver' => 'slack',
            'url' => env('SLACK_WEB_HOOK_ERROR','http://example.com'),
            'username' => env('LOG_SLACK_USER','Server Machine'),
            'emoji' => ':boom:',
            'level' => 'error',
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

];
