<?php

declare(strict_types=1);

namespace Core\Faber;

class Faber
{
    protected Stampa $stampa;
    public function __construct()
    {
        $this->stampa = new Stampa();
    }

    public function eseguiComando(array $argomenti): void
    {
        $name = "Mondo";
        if (isset($argomenti[1])) {
            $name = $argomenti[1];
        }

        $this->stampa->scriviMessaggio("Ciao, $name!");
    }

}