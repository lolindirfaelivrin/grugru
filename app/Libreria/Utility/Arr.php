<?php

namespace Libreria\Utility;

class Arr
{
    public static function wrap($valore):array
    {
        if(is_null($valore))
        {
            return [];
        }

        return is_array($valore) ? $valore : [$valore];
    }

    public static function toCssClass($valore): string
    {
        $classList = static::wrap($valore);

        $classi = [];

        foreach($classList as $valore => $chiave)
        {
            if(is_numeric($valore))
            {
                $classi[] = $chiave;
            } else {
                $classi[] = $chiave;
            }
        }

        return implode(' ', $classi);

    }

    public static function toCssLista($valore):string
    {
        $classList = static::wrap($valore);

        $classi = [];

        foreach ($classList as $key => $value) {
            if(is_numeric($key))
            {
                $classi[] = Str::fine($value, ';');
            } else {
                $classi[] = Str::fine($valore, ';');
            }
        }

        return implode(' ', $classi);
    }

}