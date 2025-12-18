<?php

return [
    'proxies' => ['*'],
    'headers' => [
        'FORWARDED' => 'FORWARDED',
        'CLIENT_IP' => 'X_FORWARDED_FOR',
        'CLIENT_HOST' => 'X_FORWARDED_HOST',
        'CLIENT_PROTO' => 'X_FORWARDED_PROTO',
        'CLIENT_PORT' => 'X_FORWARDED_PORT',
    ],
];
