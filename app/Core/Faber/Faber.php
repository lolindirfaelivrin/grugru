<?php

declare(strict_types=1);

namespace Core\Faber;

use Core\Faber\Contratti\ComandiInterface;

class Faber
{
    private const int EXIT_OK = 0;
    private const int EXIT_ERROE = 1;

    /**
     * Elenco dei comandi registrati.
     * @var array<string, ComandiInterface>
     */
    private array $comandiRegistrati = [];

    public function __construct()
    {

    }

    public function regista(ComandiInterface $comando): Faber
    {
        $nomeComando = $comando->getNomeComando();
        $this->comandiRegistrati[$nomeComando] = $comando;

        return $this;
    }

    public function registraComandi(array $comandi): Faber
    {
        foreach ($comandi as $comando) {
            $this->regista($comando);
        }

        return $this;
    }

    public function ottieniComando(string $nomeComando): ?ComandiInterface
    {
        return $this->comandiRegistrati[$nomeComando] ?? null;
    }

    public function ottieniComandi(): array
    {
        return $this->comandiRegistrati;
    }

    public function esegui(array $argomenti): int
    {

        $nomeComando = $argomenti[1] ?? 'lista:comandi';
        $comando = $this->ottieniComando($nomeComando);

        if ($comando === null) {
            $this->mostraErrore($nomeComando);
            return self::EXIT_ERROE;
        }

        if (in_array('--help', $argomenti, true)) {
            $this->mostraAiuto($comando);
            return self::EXIT_OK;
        }

        return $comando->esegui($argomenti);
    }

    private function mostraErrore(string $messaggio): void
    {
        echo "\e[31m✖  Comando \"\e[1m{$messaggio}\e[0m\e[31m\" non trovato.\e[0m" . PHP_EOL;
        echo "   Usa \e[33mphp faber.php lista:comandi\e[0m per vedere i comandi disponibili." . PHP_EOL;
    }

    private function mostraAiuto(ComandiInterface $comando): void
    {
        $uso = $comando->getUso();
        echo PHP_EOL;
        echo "\e[1m" . $comando->getNomeComando() . "\e[0m — " . $comando->getDescrizione() . PHP_EOL;
        echo PHP_EOL;

        foreach ($uso as $linea) {
            echo "\e[33mUsage:\e[0m  " . $linea . PHP_EOL;
        }

        echo PHP_EOL;
    }


}