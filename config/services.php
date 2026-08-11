<?php

return [

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
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

    // Documentation : https://aangaraa-pay.com/integrate-aangaraa-pay
    'aangaraa_pay' => [
        'base_url' => env('AANGARAA_PAY_BASE_URL', 'https://api-production.aangaraa-pay.com'),
        'app_key' => env('AANGARAA_PAY_APP_KEY'),
    ],

];
