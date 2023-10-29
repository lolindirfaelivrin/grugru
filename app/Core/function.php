<?php
use Core\Http\Redirect;
use Core\Http\Response;

if (!function_exists('dd'))
{
    /**
     * Fa il dump di variabile/i a schermo e interrompe l'esecuzione dello script
     *
     * @param mixed $dati variabile/i da mostrare
     * @return mixed
     */
    function dd(...$dati)
    {
        echo '<pre>';
        var_dump(...$dati);
        echo '</pre>';
        exit;
    }
}

if (!function_exists('dump'))
{
    /**
     * Fa il dump di variabile/i a schermo
     *
     * @param  mixed $dati variabile/i da mostrare
     * @return mixed
     */
    function dump(...$dati)
    {
        echo '<pre>';
        var_dump(...$dati);
        echo '</pre>';
    }

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

if( !function_exists('redirect'))
{
    /**
     * Reindirizza ad una spacifica pagina
     *
     * @param string $url indirizzo a cui si deve essere inviati
     * @return Response
     */
    function redirect($url): Response
    {
        return new Redirect($url);
    }
}