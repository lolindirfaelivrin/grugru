<?php

declare(strict_types=1);

namespace Core\Faber\Contratti;

interface ComandiInterface
{
    public function getNomeComando(): string;

    public function getDescrizione(): string;

    public function getUso(): array;
    /**
     * Esegue il comando con gli argomenti forniti.
     *
     * @param array<string, string|bool> $argomenti  Argomenti/opzioni processati.
     */
    public function esegui(array $argomenti): int;
}