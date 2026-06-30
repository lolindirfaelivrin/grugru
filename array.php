<?php

$dimensione = [
    'nome' => 'Dimensione',
    'valore' => [
        'piccolo' => 'Piccolo',
        'medio' => 'Medio',
        'grande' => 'Grande',
        'peso' => [
            'leggero' => 'Leggero',
            'medio' => 'Medio',
            'pesante' => 'Pesante'
        ]
    ]
];

function exists($array, $key)
{
    return array_key_exists($key, $array);
}

function elemento(string $elemento)
{
    global $dimensione;

    if (!str_contains($elemento, '.')) {
        return $dimensione[$elemento];
    }

    foreach (explode('.', $elemento) as $key) {
        if (!exists($dimensione, $key) || !is_array($dimensione)) {
            return null;
        }
        $dimensione = &$dimensione[$key];
    }

    return $dimensione;


}

#var_dump(PHP_EOL);
var_dump(elemento('valore.peso.pesante'));
#var_dump($dimensione['valore']['piccolo']);

# $dimensione['valore']['piccolo'];