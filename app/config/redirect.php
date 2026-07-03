<?php

/*
|--------------------------------------------------------------------------
| Definsco le regole di redirect
|--------------------------------------------------------------------------
|
| Elenco dei siti web che possono essere raggiunti dal mio sito, in caso contrario viene lanciata un'eccezione 
|
*/

return [


    /*
    |----------------------------------------------------------------------
    | Sito web principale
    |----------------------------------------------------------------------
    */
    'sito' => env('APP_URL', 'https://localhost'),

    'redirect' => [
        'https' => env('REDIRECT_HTTPS', false),
        'www' => env('REDIRECT_WWW', false),
        'non-www' => env('REDIRECT_NON_WWW', false)
    ],

    /* 
    |----------------------------------------------------------------------
    | Elenco dei domini consentiti
    |----------------------------------------------------------------------
    */

    'domini_consentiti' => [
        'tuodominio.it',
        'www.tuodominio.it',
        'checkout.stripe.com',
        'accounts.google.com',
    ],


];