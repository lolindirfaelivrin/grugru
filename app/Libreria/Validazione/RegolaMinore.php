<?php

namespace Libreria\Validazione;

use Core\Interface\ValidazioneInterfaccia;

class RegolaMinore implements ValidazioneInterfaccia
{
    public function __construct(private string|int $confronto)
    {
    }
    public function messaggio(string $attributo): string
    {
        return $attributo . " deve essere minore di: {$this->confronto}";
    }

    public function valida($valore): bool
    {
        if (is_string($valore)) {
            return strlen($valore) < $this->confronto;
        }

        if (is_numeric($valore)) {
            return $valore < $this->confronto;
        }

        return false;
    }
}