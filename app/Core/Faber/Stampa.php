<?php
namespace Core\Faber;


class Stampa
{
    private function stampaMessaggio(string $messaggio): void
    {
        echo $messaggio . PHP_EOL;
    }

    public function nuovaRiga(): void
    {
        echo PHP_EOL;
    }

    public function scriviMessaggio(string $messaggio): void
    {
        $this->nuovaRiga();
        $this->stampaMessaggio($messaggio);
        $this->nuovaRiga();

    }
}