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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '367028965620-d1lcnvo0nhdhgqjaclgoqsl1qul16669.apps.googleusercontent.com',
        'client_secret' => 'ZOhqYSpQPJ7lLe21NJNaw0tR',
        'redirect' => 'http://rhust.app.com/auth/google-callback',
    ],

    'facebook' => [
        'client_id' => '995878191232465',
        'client_secret' => 'abf95424ec8b6567ff688a14b2f719d5',
        'redirect' => 'https://127.0.0.1/:8000/auth/facebook/callback',
    ],
];
