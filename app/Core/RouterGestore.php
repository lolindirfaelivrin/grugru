<?php
namespace Core;
use Core\Exception\RottaNonTrovata;
class RouterGestore
{
    protected array $rotte = [];

    public function carica(): void
    {
        $rotte = $this->rotteRegistrate();

        foreach($rotte as $rotta)
        {
            $fileRotta = GruGru::$ROOTDIR.'/rotte/'.$rotta.'.php'; 

            #if(!file_exists(dirname($fileRotta))) con dirname non funziona
            if(!file_exists($fileRotta))
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

    public function registraRotta(array|string $rotta)
    {
        $this->rotte = []; 

        if(is_string($rotta))
        {
            array_push($this->rotte, $rotta);
            $this->carica();

            return;
        }

        foreach($rotta as $nome)
        {
            array_push($this->rotte, $nome);
        }

        $this->carica();
    }

    private function registra(): array
    {
        return [
            'r', 'utente'
        ];

    }
    
}