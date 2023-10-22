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

    public function aggiungi(string $chiave, mixed $valore)
    {
        $this->aggiungiChiaveValore($chiave, $valore);
    }

    public function mostra(string $chiave)
    {
        if($this->esisteChiave($chiave))
        {
            return $this->prendiValoreChiave($chiave);
        }
    }
}