<?php

return [

    /**
     * Stabilisce che tipo di database andrò a usere se nessun database è indicato
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
            'prefix' => env('DB_PREFIX', 'grugru_'),
            'transaction' => true,

            /**
             * Array dei PRAGMA specifici per SQLite.
             * Verranno eseguiti subito dopo l'apertura della connessione PDO.
             */
            'pragmas' => [
                'foreign_keys' => 'ON',      // Abilita i vincoli delle chiavi esterne (fondamentale per relazionali)
                'journal_mode' => 'WAL',     // Write-Ahead Logging per migliori performance in concorrenza
                'synchronous' => 'NORMAL',  // Ottimo compromesso tra sicurezza dei dati e velocità
                'cache_size' => '-20000',  // Imposta la cache a circa 20MB (i valori negativi indicano i KB)
                'temp_store' => 'MEMORY',     // Usa la memoria per le tabelle temporanee (più veloce)
            ]
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