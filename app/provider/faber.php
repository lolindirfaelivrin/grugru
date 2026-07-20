<?php

use Core\Faber\Comandi\infoComandi;
use Core\Faber\Comandi\manutenzioneComando;
use Core\Faber\Comandi\nuovoComandoComandi;
use Core\Faber\Comandi\phpServerComandi;


/**
 * Provider per Faber, elenco dei comandi disponibili per il framework.
 */

return [
    infoComandi::class,
    manutenzioneComando::class,
    nuovoComandoComandi::class,
    phpServerComandi::class,
];

