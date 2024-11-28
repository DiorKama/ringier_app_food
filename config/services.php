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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'wave' => [
        'url' => 'https://api.wave.com/v1/checkout/sessions',
        'auth_bearer' => 'wave_sn_prod_lcxgroer0xj-zte-QKR5pxFg1YjXxVa5qFtF7kbxP-khESGKlTcUn_cWgqHhZwQvExXVa4J_kqgt-EBb-R3374Ycm7-65jiPXQ',
        'currency' => 'XOF',
        'webhook_secret' => 'wave_sn_WHS_qhke62y2tc16jmheq9mbdqa644mktmng2eyhzbe857sd2n3tq9g0',
    ],
    'orange-money'
];


