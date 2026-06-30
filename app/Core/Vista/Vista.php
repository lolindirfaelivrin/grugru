<?php

declare(strict_types=1);

namespace Core\Vista;

use Core\Exception\VistaNonTrovata;
use Core\GruGru;

class Vista
{
    private string $estensione = '.php';

    public function setEstensione(string $estensione): static
    {
        $this->estensione = $estensione;
        return $this;
    }

    public function render(string $vista, array $data = []): string
    {
        $percorso = $this->generaPercorso($vista);
        $percorsoCompleto = GruGru::$ROOTDIR . '/views/' . $percorso . $this->estensione;

        if (!\file_exists($percorsoCompleto)) {
            throw new VistaNonTrovata($vista);
        }

        return $this->generaOutput($percorsoCompleto, $data);
    }

    private function generaOutput(string $percorso, array $data): string
    {
        \extract($data, EXTR_SKIP);

        ob_start();
        try {
            require $percorso;
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }
        return ob_get_clean();
    }

    private function generaPercorso(string $vista): string
    {
        return implode(DIRECTORY_SEPARATOR, explode('.', $vista));
    }
}