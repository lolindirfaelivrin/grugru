<?php

namespace Libreria\Validazione;
use Core\Interface\ValidazioneInterfaccia;

class RegolaMaggiore implements ValidazioneInterfaccia
{
    public function __construct(private string|int $confronto)
    {
    }
    public function messaggio(string $attributo): string
    {
        return $attributo. " deve essere maggiore di: {$this->confronto}";
    }

    public function valida($valore): bool
    {
        if(is_string($valore))
        {
            return strlen($valore) > $this->confronto;
        }

        if(is_numeric($valore))
        {
            return $valore > $this->confronto;
        }

        return false;
    }
}