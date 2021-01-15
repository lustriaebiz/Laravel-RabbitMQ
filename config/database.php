<?php

    return [
        'default' => 'mysql',
        'connections' => [
            'mysql' => [ 
                'driver' => 'mysql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => env('DB_DATABASE', ''),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD'),
                'options' => [
                    'database' => env('DB_DATABASE_OPTION') // sets the authentication database required by mongo 3
                ]
            ]
        ],
        'migrations' => 'migrations'
    ];