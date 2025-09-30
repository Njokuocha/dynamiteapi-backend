<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:3000', 
        'http://192.168.52.92:3000', 
        'http://localhost',
    ],
    'allowed_headers' => ['*'],
    'supports_credentials' => false, // no cookies needed here

];
