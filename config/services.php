<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'elastic' => [
        'cities_endpoint' => env('ANALYTIC_CITIES_ENDPOINT'),
        'countries_endpoint' => env('ANALYTIC_COUNTRIES_ENDPOINT'),
        'destination_autonomous_bytes_endpoint' => env('ANALYTIC_DESTINATION_AUTONOMOUS_BYTES_ENDPOINT'),
        'source_autonomous_bytes_endpoint' => env('ANALYTIC_SOURCE_AUTONOMOUS_BYTES_ENDPOINT'),
        'destination_autonomous_packets_endpoint' => env('ANALYTIC_DESTINATION_AUTONOMOUS_PACKETS_ENDPOINT'),
        'source_autonomous_packets_endpoint' => env('ANALYTIC_SOURCE_AUTONOMOUS_PACKETS_ENDPOINT'),
        'destination_ip_endpoint' => env('ANALYTIC_DESTINATION_IP_ENDPOINT'),
        'source_ip_endpoint' => env('ANALYTIC_SOURCE_IP_ENDPOINT'),
        'destination_ports_endpoint' => env('ANALYTIC_DESTINATION_PORT_ENDPOINT'),
        'source_ports_endpoint' => env('ANALYTIC_SOURCE_PORT_ENDPOINT'),
    ],

];
