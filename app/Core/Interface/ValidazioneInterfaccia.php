<?php
namespace Core\Interface;
interface ValidazioneInterfaccia
{
    public function messaggio(string $messaggio): string;
    public function valida($valore): bool;
}