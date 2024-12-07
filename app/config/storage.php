<?php

return [

    'predefinito' => env('DISCO', 'locale'),

    'dischi' => [

        'locale' => [
            'driver' => 'locale',
            'root' => 'app'
        ],

        'public' => [
            'driver' => 'locale',
            'root' => 'app/public',
            'url' => env('APP_URL').'/storage',
            'visibilita' => 'publica'
        ]

    ]
];
