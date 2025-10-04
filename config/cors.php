<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:3000', 
        'http://10.171.123.92:3000', 
        'http://localhost',
        'https://dynamiteapi.vercel.app'
    ],
    'allowed_headers' => ['*'],
    'supports_credentials' => false, // no cookies needed here

];
