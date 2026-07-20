<?php

use Libreria\Falsifica\NomiFalsi;
use Libreria\Falsifica\NumeriFalsi;
use Libreria\Falsifica\PersonaFalsa;

/*
* Gestione provider del database per la generazione di dati falsi.
*/

return [
    NomiFalsi::class => null,
    NumeriFalsi::class => null,
    PersonaFalsa::class => fn () => new PersonaFalsa(new NomiFalsi(), new NumeriFalsi()),
];