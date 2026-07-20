<?php

declare(strict_types=1);

namespace Core\Faber\Comandi;

use Core\Faber\ComandoAstratto;

class PhpServerComandi extends ComandoAstratto
{
    public function getNomeComando(): string
    {
        return "php:server";
    }

    public function getDescrizione(): string
    {
        return "Avvia un server PHP integrato per lo sviluppo.";
    }

    public function getUso(): array
    {
        return [
            "Uso: php faber.php php:server [host] [porta]",
            "Avvia un server PHP integrato per lo sviluppo.",
            "Esempio: php faber.php php:server localhost 8000",
        ];
    }

    public function esegui(array $argomenti): int
    {
        $host = $argomenti[1] ?? 'localhost';
        $porta = $argomenti[2] ?? '8000';

        $this->scriviLinea("Avvio del server PHP integrato su http://$host:$porta");
        $this->scriviLinea("Premi Ctrl+C per interrompere il server.");

        // Avvia il server PHP integrato
        passthru("php -S $host:$porta");

        return 0;
    }
}