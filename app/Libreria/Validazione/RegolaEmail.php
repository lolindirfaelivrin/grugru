<?php

namespace Libreria\Validazione;
use Core\Interface\ValidazioneInterfaccia;

/**
 * Controlla se una Email è valida
 */
class RegolaEmail implements ValidazioneInterfaccia
{
    public function messaggio(string $attributo): string
    {
        return $attributo . ' deve essere una email valida';
    }

    public function valida($valore): bool
    {
        return filter_var($valore, FILTER_VALIDATE_EMAIL);
    }

}