<?php

declare(strict_types=1);

namespace Core\Faber\Comandi;

use Core\Faber\ComandoAstratto;
use Core\Faber\Faber;

class ListaComandi extends ComandoAstratto
{
    public function __construct(private readonly Faber $faber)
    {

    }

    public function getNomeComando(): string
    {
        return "lista:comandi";
    }

    public function getDescrizione(): string
    {
        return "Mostra l'elenco dei comandi disponibili.";
    }

    public function getUso(): array
    {
        return [
            "Uso: php faber.php lista:comandi",
            "Mostra l'elenco dei comandi disponibili.",
        ];
    }

    public function esegui(array $argomenti): int
    {
        $comandi_registrati = $this->faber->ottieniComandi();

        if (empty($comandi_registrati)) {
            $this->errore("Nessun comando registrato.");
            return 1; // Indica un errore
        }

        //Ottenere la lunghezza massima del nome del comando per l'allineamento
        $maxLen = max(array_map(fn($c) => \strlen($c->getNomeComando()), $comandi_registrati));

        $this->scriviLinea();
        $this->scriviLinea("\e[1m\e[36m  Faber CLI\e[0m");
        $this->separatore();
        $this->scriviLinea("\e[33m  Comandi Disponibili:\e[0m");
        $this->scriviLinea();


        foreach ($comandi_registrati as $nomeComando) {

            $nome = str_pad($nomeComando->getNomeComando(), $maxLen + 2);
            $descrizione = $nomeComando->getDescrizione();
            $this->scriviLinea("  \e[32m{$nome}\e[0m  {$descrizione}");

        }

        $this->scriviLinea();

        return 0; // Indica che il comando è stato eseguito con successo.
    }
}