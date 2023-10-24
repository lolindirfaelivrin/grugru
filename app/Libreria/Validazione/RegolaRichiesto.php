<?php

namespace Libreria\Validazione;
use Core\Interface\ValidazioneInterfaccia;

class RegolaRichiesto implements ValidazioneInterfaccia
{
    public function messaggio(string $attributo): string
    {
        return $attributo.' è richiesto';
    }

    public function valida($valore): bool
    {
        return isset($valore) && $valore !== '';
    }

}