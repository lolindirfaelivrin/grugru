<?php

namespace Core\Middlewear;

class LoggingMiddlewear
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
            $logMessage = date('Y-m-d H:i:s') . ' - ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
            file_put_contents($fileLog, $logMessage . PHP_EOL, FILE_APPEND);
        }
    }
}