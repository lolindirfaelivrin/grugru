#!/usr/bin/php
<?php

use Core\Faber\Comandi\ListaComandi;
use Libreria\Autoload;



if (php_sapi_name() !== 'cli') {
    exit;
}



require 'app/Libreria/Autoload.php';
Autoload::register();

$faber = new \Core\Faber\Faber();
$faber->regista(new ListaComandi($faber));


$faber->registraComandi([
    new \Core\Faber\Comandi\InfoComandi(),
    new \Core\Faber\Comandi\ManutenzioneComando(),
    new \Core\Faber\Comandi\NuovoComandoComandi(),
    new \Core\Faber\Comandi\PhpServerComandi(),
]);

$codice_uscita = $faber->esegui($argv);
exit($codice_uscita);