<?php

namespace Core\Middlewear;
use Core\GruGru;

class LoggingMiddlewear extends Middlewear
{
    public array $azioni = [];

    public function __construct(array $azioni = [])
    {
        $this->azioni = $azioni;
    }

    public function esegui()
    {
        if(in_array(GruGru::$APP->controller->azione, $this->azioni))
        {
            $fileLog = GruGru::$ROOTDIR.'/storage/log/request_' . gmdate('d_m_Y') . '.log';
            $logMessage = date('d-m-Y H:i:s') . ' - ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
            file_put_contents($fileLog, $logMessage . PHP_EOL, FILE_APPEND);
        }
    }
}