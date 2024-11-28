<?php

return [
    'methods' => [
        'orange-money',
        'wave',
    ],

    'wave' => [
        'url' => 'https://api.wave.com/v1/checkout/sessions',
        'auth_bearer' => 'wave_sn_prod_xxxxxxxxxxxxxxxxxx',
        'currency' => 'XOF',
        'webhook_secret' => 'wave_sn_WHS_xxxxxxxxxxxxxxxxxx',
    ],

    'orange-money' => [],
];
