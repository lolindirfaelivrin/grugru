<?php
use Core\GruGru;
echo 'PHP: '.phpversion();
echo ' GruGru: '.GruGru::$VERSIONE;
error_log("Errore:  {$e->getMessage()} : {$e->getFile()}", 0);
?>


    <div style='text-align: center;'>
    <h2 style='color: rgb(190, 50, 50);'>Sono stati compiuti errori:</h2>
    <table style='width: 800px; display: inline-block;'>
    <tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Data & Ora</th><td><?php echo date('d-m-Y H:i:s') ?></td></tr>
    <tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Tipo</th><td><?php echo get_class($e) ?></td></tr>
    <tr style='background-color:rgb(240,240,240);'><th style='width: 80px;'>Messaggio errore</th><td><?php echo $e->getMessage() ?></td></tr>
    <tr style='background-color:rgb(230,230,230);'><th>File</th><td><?php echo $e->getFile() ?></td></tr>
    <tr style='background-color:rgb(240,240,240);'><th>Linea</th><td><?php echo $e->getLine() ?></td></tr>
    <tr style='background-color:rgb(240,240,240);'><th>Trace</th><td><pre><?php echo preg_replace("/\n/", '<br>', $e->getTraceAsString()) ?></pre></td></tr>
    </table></div>

    <?php
    /*
    $message = "Type: " . get_class($e) . "; Message: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()};";
    file_put_contents($config["app_dir"] . "/tmp/logs/exceptions.log", $message . PHP_EOL, FILE_APPEND);
    header("Location: {$config["error_page"]}");
    */
    exit();  
    ?>