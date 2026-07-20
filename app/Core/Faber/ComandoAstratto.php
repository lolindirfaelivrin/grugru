<?php
declare(strict_types=1);

namespace Core\Faber;
use Core\Faber\Contratti\ComandiInterface;

abstract class ComandoAstratto implements ComandiInterface
{
    protected function scriviLinea(string $messaggio = ""): void
    {
        echo $messaggio . PHP_EOL;
    }

    protected function scriviUso(array $uso): void
    {
        foreach ($uso as $linea) {
            $this->scriviLinea($linea);
        }
    }

    protected function info(string $text): void
    {
        $this->scriviLinea("\e[36m" . $text . "\e[0m");
    }

    protected function successo(string $text): void
    {
        $this->scriviLinea("\e[32m" . $text . "\e[0m");
    }

    protected function errore(string $text): void
    {
        $this->scriviLinea("\e[31m" . $text . "\e[0m");
    }

    protected function separatore(int $lunghezza = 60): void
    {
        $this->scriviLinea(str_repeat("-", $lunghezza));
    }

}