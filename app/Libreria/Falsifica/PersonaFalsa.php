<?php

declare(strict_types=1);

namespace Libreria\Falsifica;

class PersonaFalsa
{
    public function __construct(private NomiFalsi $nomiFalsi, private NumeriFalsi $numeriFalsi)
    {
        // Costruttore vuoto
    }

    public function Uomo(): array
    {
        return $this->generaPersonaFalsa('maschile');
    }

    public function Donna(): array
    {
        return $this->generaPersonaFalsa('femminile');
    }  

    private function generaPersonaFalsa(string $genere = 'maschile'): array
    {
        //$genere = rand(0, 1) === 0 ? 'maschile' : 'femminile';
        $nomeCompleto = $genere === 'maschile' ? $this->nomiFalsi->nomeUomo() : $this->nomiFalsi->nomeDonna();
        $eta = $this->numeriFalsi->generaNumeroCompreso(18, 80);

        return [
            'nome_completo' => $nomeCompleto,
            'genere' => $genere,
            'eta' => $eta,
            'telefono_mobile' => $this->numeriFalsi->generaNumeroTelefonoMobileFalso(),
            'telefono_fisso' => $this->numeriFalsi->generaNumeroTelefonoFissoFalso(),
            'email' => strtolower(str_replace(' ', '.', $nomeCompleto)) . '@esempio.com',
        ];
    }
    
}