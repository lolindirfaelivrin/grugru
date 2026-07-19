<?php
declare(strict_types=1);

namespace Core\Faber\Comandi;

use Core\Faber\ComandoAstratto;

class ManutenzioneComando extends ComandoAstratto
{
    public function getNomeComando(): string
    {
        return "manutenzione";
    }

    public function getDescrizione(): string
    {
        return "Mette il sito in modalità manutenzione.";
    }

    public function getUso(): array
    {
        return [
            "Uso: php faber.php manutenzione",
            "Mette il sito in modalità manutenzione.",
        ];
    }

    public function esegui(array $argomenti): int
    {
        // Logica per eseguire le operazioni di manutenzione
        $this->scriviLinea("Messa in modalità manutenzione...");
        // Aggiungi qui le operazioni specifiche di manutenzione

        return match ($argomenti[1] ?? '') {
            'attiva' => $this->attivaManutenzione(),
            'disattiva' => $this->disattivaManutenzione(),
            default => $this->attivaManutenzione(), // Imposta la modalità manutenzione come predefinita
        };
    }

    private function attivaManutenzione(): int
    {
        // Logica per attivare la modalità manutenzione
        $this->scriviLinea("Modalità manutenzione attivata.");
        return 0;
    }

    private function disattivaManutenzione(): int
    {
        // Logica per disattivare la modalità manutenzione
        $this->scriviLinea("Modalità manutenzione disattivata.");
        return 0;
    }
}