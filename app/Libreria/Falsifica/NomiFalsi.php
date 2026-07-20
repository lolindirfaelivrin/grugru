<?php
declare(strict_types=1);

namespace Libreria\Falsifica;

class NomiFalsi
{
    private array $nomiMaschili = [
        'Luca', 'Marco', 'Giovanni', 'Francesco', 'Andrea',
        'Matteo', 'Alessandro', 'Davide', 'Simone', 'Stefano'
    ];

    private array $nomiFemminili = [
        'Maria', 'Giulia', 'Francesca', 'Chiara', 'Sara',
        'Elena', 'Martina', 'Valentina', 'Federica', 'Laura'
    ];

    private array $cognomi = [
    "Rossi", "Russo", "Ferrari", "Esposito", "Bianchi",
    "Romano", "Colombo", "Ricci", "Marino", "Greco"
    ];

    public function nomeFemminile(): string
    {
        return $this->generaNomeFalso('femminile');
    }

    public function nomeMaschile(): string
    {
        return $this->generaNomeFalso('maschile');
    }

    public function nomeUomo(): string
    {
        return "{$this->generaNomeFalso('maschile')} {$this->cognomi[array_rand($this->cognomi)]}";
    }

    public function nomeDonna(): string
    {
        return "{$this->generaNomeFalso('femminile')} {$this->cognomi[array_rand($this->cognomi)]}";
    }

    private function generaNomeFalso(string $genere = 'maschile'): string
    {
        if ($genere === 'femminile') {
            return $this->nomiFemminili[array_rand($this->nomiFemminili)];
        }
        return $this->nomiMaschili[array_rand($this->nomiMaschili)];
    }

    private function generaNomiFalsi(int $count = 10, string $genere = 'maschile'): array
    {
        $nomiFalsi = [];
        for ($i = 0; $i < $count; $i++) {
            $nomiFalsi[] = $this->generaNomeFalso($genere);
        }
        return $nomiFalsi;
    }
}