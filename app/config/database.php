<?php

return [

    /**
     * Stabilisce che tipo di database andrò a usere se nessun dataabase è indicato
     */
    'default' => env('DB_DRIVER', 'sqlite'),

    'connection' => [

        /**
         * Configurazione specifica per sqlite
         */
        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL', 'database'),
            'database' => env('DB_DATABASE', 'grugru.sqlite'),
            'prefix' => env('DB_PREFIX', 'grugru_')
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'user' => env('DB_USER', 'root'),
            'password' => env('DB_PASS', ''),
            'prefix' => env('DB_PREFIX', 'grugru_'),
            'database' => env('DB_DATABASE', 'grugru'),
        ]
    ]

];