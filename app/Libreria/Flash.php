<?php

namespace Libreria;
use Core\Session;

class Flash extends Session
{
    private string $chiave_flash;

    public function __construct(string $chiave_flash = '__grugru_flash')
    {
        parent::__construct();
        $this->chiave_flash = $chiave_flash;
    }

    public function aggiungi(string $chiave, mixed $valore): void
    {
        $flash = $this->prendiValoreChiave($this->chiave_flash) ?? [];
        $flash[$chiave][] = $valore;
        $this->aggiungiChiaveValore($this->chiave_flash, $flash);
    }

    public function mostra(string $chiave):array
    {
        $flash = $this->prendiValoreChiave($this->chiave_flash) ?? [];
        if (isset($flash[$chiave])) {
            $messaggio = $flash[$chiave];
            unset($flash[$chiave]);
            $this->aggiungiChiaveValore($this->chiave_flash, $flash);
            return $messaggio;
        }
        return [];
    }
}