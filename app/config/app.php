<?php

return [
    'nome' => $_ENV['APP_NAME'],
    'env' => $_ENV['APP_ENV'],
    'debug' => $_ENV['APP_DEBUG'],
    'log' => env('APP_LOG', false),
    'chiave' => $_ENV['APP_CHIAVE'],
    'url'=> $_ENV['APP_URL'],

    'timezone' => 'UTC',
    'charset' => 'UTF-8'
];