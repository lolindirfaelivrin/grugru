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
     * @see https://youtu.be/EI0nTQle4vw?si=h0HpFLccv1su2P0E
     */
    function dd(...$dati)
    {
        $traccia = debug_backtrace();
        $file = $traccia[0]['file'];
        $linea = $traccia[0]['line'];

        echo "<div style='font-family: monospace'>";
        echo "// $file:$linea\n";
        echo '<pre>';
        var_dump(...$dati);
        echo '</pre></div>';
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
        $traccia = debug_backtrace();
        $file = $traccia[0]['file'];
        $linea = $traccia[0]['line'];

        echo "// $file:$linea\n";
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

if( !function_exists('vuoto'))
{
    /**
     * Determina se una variabile è vuota
     * @param mixed $valore
     * @return bool
     */

     function vuoto($valore)
     {
        if(is_null($valore))
        {
            return true;
        }

        if (is_string($valore)) {
            return trim($valore) === '';
        }

        if (is_numeric($valore) || is_bool($valore)) {
            return false;
        }        

        return empty($valore);

     }
}

if(! function_exists('pieno'))
{
    /**
     * Determina se una variabile ha un valore
     *
     * @param mixed $valore
     * @return bool
     */
    function pieno($valore)
    {
        return !vuoto($valore);
    }
}

if( !function_exists('e'))
{
    /**
     * Encode HTML special characters di una stringa
     *
     * @param string $valore
     * @param boolean $doubleEncode
     * @return string
     */
    function e($valore, $doubleEncode = true)
    {
        return htmlspecialchars($valore ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
    }

}

if (! function_exists('windows_os')) {
    /**
     * Deternina se il sistema attuale è un sistema della famiglia Windows.
     *
     * @return bool
     */
    function windows_os()
    {
        return PHP_OS_FAMILY === 'Windows';
    }
}

if (! function_exists('memoriaInFormatoUmano'))
{
    /**
     * Trasforma i bity in un formato leggibile
     * ! Da spostare in eventuale libreria dedicata
     * TODO: capire il fomato di $size
     *
     * @param string $size
     * @return string
     */
    function memoriaInFormatoUmano($size)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}

    function nl2p($string)
    {
        #return $string_with_paragraphs = "<p>".implode("</p><p>", explode("\n", $string))."</p>";
        return "<p>".implode("</p><p>", explode("\n", $string))."</p>";
    }