<?php

declare(strict_types=1);

namespace Core\Faber\Comandi;

use Core\Faber\ComandoAstratto;

class NuovoComandoComandi extends ComandoAstratto
{
    public function getNomeComando(): string
    {
        return "nuovo:comando";
    }

    public function getDescrizione(): string
    {
        return "Crea un nuovo comando personalizzato.";
    }

    public function getUso(): array
    {
        return [
            "Uso: php faber.php nuovo:comando <nome_comando>",
            "Crea un nuovo comando personalizzato con il nome specificato.",
        ];
    }

    public function esegui(array $argomenti): int
    {
        $nomeComando = $argomenti[1] ?? null;

        if ($nomeComando === null) {
            $this->errore("Devi specificare un nome per il nuovo comando.");
            return 1;
        }

        // Logica per creare un nuovo comando personalizzato
        $this->scriviLinea("Creazione del nuovo comando: $nomeComando");
        // Qui puoi aggiungere la logica per generare il file del comando o altre operazioni necessarie.

        return 0;
    }
}