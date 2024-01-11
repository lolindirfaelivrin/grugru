<?php
namespace Core;
use Core\Exception\RottaNonTrovata;
class RouterGestore
{
    protected array $rotte = [];
    public function __construct()
    {
        $this->carica();
    }
    public function carica(): void
    {
        $this->rotte = $this->registra();

        foreach($this->rotte as $rotta)
        {
            $fileRotta = GruGru::$ROOTDIR.'/rotte/'.$rotta;

            if(!file_exists(dirname($fileRotta)))
            {
                throw new RottaNonTrovata('File di rotta non trovato');
            }
            require $fileRotta;
        }
    }
    public function rotteRegistrate()
    {
        return $this->rotte;
    }

    private function registra(): array
    {
        return [
            'web.php'
        ];

    }
    
}