<?php

function dd($dati)
{
    echo '<pre>';
    var_dump($dati);
    echo '</pre>';
    exit;
}

function dump($dati)
{
    echo '<pre>';
    var_dump($dati);
    echo '</pre>';
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function env($key, $default = null): ?string
    {
        return $_ENV[$key] ?? $default;
    }
}