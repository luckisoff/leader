<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

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
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('FB_CLIENT_ID'),
        'client_secret' => env('FB_CLIENT_SECRET'),
        'redirect' => env('FB_CALL_BACK'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_CALL_BACK'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_CALL_BACK'),
    ],

    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_CALL_BACK'),
    ],

    'khalti'=>[
        'client_id'=>env('KHALTI_KEY'),
        'client_secret'=>env('KHALTI_SECRET')
    ],

    'paypal'=>[
        'client_id'=>env('PAYPAL_KEY'),
        'client_secret'=>env('PAYPAL_SECRET'),
        'mode'=>env('PAYPAL_MODE')
    ],

    'transactionapi'=>[
        'esewapay'=>env('ESEWA_PAYMENT'),
        'esewaverify'=>env('ESEWA_VERIFY'),
        'khaltiverify'=>env('KHALTI_VERIFY'),
    ],

    'payment'=>[
        'esewa'=>env('PAYMENT_ESEWA'),
        'khalti'=>env('PAYMENT_KHALTI'),
        'paypal'=>env('PAYMENT_PAYPAL')
    ],

    'leader'=>[
        'identity'=>env('LEADER_IDENTITY'),
    ]

];
