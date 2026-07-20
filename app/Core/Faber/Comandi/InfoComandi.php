<?php

declare(strict_types=1);

namespace Core\Faber\Comandi;

use Core\Faber\ComandoAstratto;

class InfoComandi extends ComandoAstratto
{
    public function getNomeComando(): string
    {
        return "info";
    }

    public function getDescrizione(): string
    {
        return "Mostra informazioni sulla versione di Grugru.";
    }

    public function getUso(): array
    {
        return [
            "Uso: php faber.php info",
            "Mostra informazioni sulla versione di Grugru.",
        ];
    }

    public function esegui(array $argomenti): int
    {
        $this->info("Informazioni sulla versione di Grugru:");
        $this->separatore();

        $sottocomando = (string) ($argomenti[1] ?? 'info:versione');


        return match ($sottocomando) {
            'info:versione' => $this->mostraVersione(),
            'info:autore' => $this->mostraAutore(),
            default => $this->mostraUso(),
        };

    }

    private function mostraVersione(): int
    {
        $this->scriviLinea("Versione di Grugru: 1.0.0");
        return 0;
    }

    private function mostraAutore(): int
    {
        $this->scriviLinea("Autore di Grugru: Il tuo nome");
        return 0;
    }

    private function mostraUso(): int
    {
        $this->scriviLinea("Uso: php faber.php info [versione|autore]");
        $this->scriviLinea("Mostra informazioni sulla versione di Grugru.");
        return 0;
    }
}