<?php

$config = [
    'RestAPI' => [
        'path' => '/api/entities/:resource',
        'auth' => [
            'jwt' => [
                'returnPayload' => false,
                'secretKey' => '123456'
            ],
            'identity' => [
                'resolver' => [
                    'className' => 'Authentication.Orm',
                    'userModel' => 'Users'
                ]
            ]
        ]
    ]
];

return $config;

