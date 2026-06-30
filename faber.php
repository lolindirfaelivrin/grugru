#!/usr/bin/php
<?php

use Libreria\Autoload;

if (php_sapi_name() !== 'cli') {
    exit;
}



require 'app/Libreria/Autoload.php';
Autoload::register();

$faber = new \Core\Faber\Faber();
$faber->eseguiComando($argv);