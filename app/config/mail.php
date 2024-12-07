<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */
    'predefinito' => env('MAIL_SERVIZIO', 'php'),

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */
    'mittente' => [
        'indirizzo' => env('MAIL_EMAIL_MITTENTE', 'grugru@grugru.com'),
        'nome' => env('MAIL_NOME_MITTENTE', 'Amministratore')
    ],

];