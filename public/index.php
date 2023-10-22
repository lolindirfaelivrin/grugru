<?php
use Core\Http\enum\HttpstatusCode;
error_reporting(E_ALL);

//Importo il file che carica tutto il necessario
use Core\GruGru;
use Libreria\Autoload;
use Libreria\DotEnv;

require '../app/Libreria/DotEnv.php';
require '../app/Libreria/Autoload.php';
require '../app/Core/function.php';


$env = new DotEnv('../.env');
$env->load();

$app = require '../app/config/app.php';
$database = require '../app/config/database.php';
$config = array_merge($app, $database);

Autoload::register();

$grugru = new GruGru(dirname(__DIR__), $config);
ini_set('error_log', GruGru::$ROOTDIR.'/storage/log/error_' . gmdate('d_m_Y') . '.log');

require '../app/rotte/web.php';

try {
    echo $grugru->router->risolvi();
} catch(Exception $errore) {

    //TODO: modificare la classe Exception che restituisca istanza di HttpstatusCode
    $grugru->response->esci($errore->getMessage(), $errore->getCode());
}


?>
