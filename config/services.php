<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
     'google_cloud' => [
        'key' => storage_path('app/credentials/google-cloud-service-account.json'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'     => App\User::class,
        'key'       => env('STRIPE_KEY'),
        'secret'    => env('STRIPE_SECRET'),
        'currency'  => env('STRIPE_CURRENCY'),
    ],

    'paypal' => [
        'client_id'     => env('PAYPAL_API_CLIENTID',''),
        'secret'        => env('PAYPAL_API_SECRET',''),
        //"app_id"        => 'APP-80W284485P519543T',
        'currency'      => env('PAYPAL_API_CURRENCY'),
        'mode'          => env('PAYPAL_API_MODE'), /* live */
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID','93115272786-s18qhfp0f1g6f650j7kdtebbhco307ai.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_SECRET','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'),
        'redirect' => env('GOOGLE_REDIRECT','https://myplace-events.com/oauth/google/callback'),
        'api_key' => env('API_KEY'),
        /*'recaptcha_key' => env('GOOGLE_RECAPTCHA_KEY'),
        'recaptcha_secret' => env('GOOGLE_RECAPTCHA_SECRET')*/

    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'), // configure with your app id
        'client_secret' => env('FACEBOOK_APP_SECRET'), // your app secret
        'redirect' => env('FACEBOOK_REDIRECT').'', // IMPORTANT NOT REMOVE /oauth/facebook/callback
    ],
    
    'linkedin' => [         
        'client_id' => env ('LINKEDIN_CLIENT_ID'),
        'client_secret' => env ('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env ('LINKEDIN_REDIRECT') 
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT'),
    ],

    'bitly' =>  [
        'api_key' => '',
    ],

    'orange_sms' => [
        'client_id' => env('ORANGESMS_CLIENT_ID', ''),
        'client_secret' => env('ORANGESMS_CLIENT_SECRET', ''),
        'dev_phone_number' => env('ORANGESMS_DEV_PHONE_NUMBER', '2250000'),
        'max_attempts' => 3,
        // store current token (don't set value manually)
        'token_type' => 'Bearer',
        'access_token' => 'W8QSL4IAQAnVoC0swlBjnNHfPo68',
    ],

    'sms_mail_pro' => [
        'api_key' => 'bWlrZWdyYW50Ojg1Mm1pa2VncmFudA==',
        'sender_id' => 'e.Dari App',
        'max_attempts' => 3,
    ]

];
