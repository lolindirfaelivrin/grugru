<?php

namespace Libreria\Utility;

class Str
{
    private static $metodi = [
        'maiuscolo' => 'strtoupper',
        'minuscolo' => 'strtolower',
        'lunghezza' => 'len',
        'titolo' => 'ucfirst',
        'paragrafo' => 'nl2p'
    ];

    public static function __callStatic(string $metodo, array $parametri)
    {
        if(!array_key_exists($metodo, self::$metodi)) 
        {
            throw new \Exception('Il metodo: '. $metodo .' non esiste');
        }

        return call_user_func_array(self::$metodi[$metodo], $parametri);   
    }
}