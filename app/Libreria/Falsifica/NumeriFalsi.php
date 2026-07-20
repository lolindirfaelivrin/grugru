<?php
declare(strict_types=1);

namespace Libreria\Falsifica;

class NumeriFalsi
{
    private array $prefissi_mobile = [
        '320', '327', '328', '329', // WindTre
        '331', '333', '334', '335', '338', '339', // TIM
        '340', '345', '347', '348', '349', // Vodafone
        '351', '353', // Iliad e MVNO
        '371', '377', '379', // MVNO vari
        '380', '388', '389' // WindTre
    ];

    private array $prefissi_fisso = [
        '02', '06', // 2 cifre: Milano, Roma
        '011', '051', '055', '081', '091', '010', '045', '049', // 3 cifre: Torino, Bologna, Firenze, Napoli, Palermo, Genova, Verona, Padova
        '0432', '0541', '0832', '0774', '0931' // 4 cifre: Udine, Rimini, Lecce, Tivoli, Siracusa
    ];


    public function generaNumeroFalso(int $max = 100): int
    {
        return rand(1, $max);
    }

    public function generaNumeriFalsi(int $count = 10, int $max = 100): array
    {
        $numeriFalsi = [];
        for ($i = 0; $i < $count; $i++) {
            $numeriFalsi[] = $this->generaNumeroFalso($max);
        }
        return $numeriFalsi;
    }

    public function generaNumeroCasualeCompreso(int $min = 1, int $max = 100): int
    {
        return rand($min, $max);
    }

    public function generaNumeroCompreso(int $min = 1, int $max = 100): int
    {
        return rand($min, $max);
    }

    public function generaNumeroTelefonoFalso(): string
    {
        return '+39 ' . $this->generaNumeroCompreso(1000000000, 9999999999);
    }

    public function generaNumeroTelefonoFissoFalso(bool $prefisso = false): string
    {
        $prefisso = $this->prefissi_fisso[array_rand($this->prefissi_fisso)];
        $lunghezzaNumero = 10 - strlen($prefisso);

        $min = pow(10, $lunghezzaNumero - 1);
        $max = pow(10, $lunghezzaNumero) - 1;

        $numero = rand($min, $max);

        $numero_completo = $prefisso . $numero;

        return $prefisso ? "+39 {$numero_completo}" : $numero_completo;
    }

    public function generaNumeroTelefonoMobileFalso(bool $prefisso = false): string
    {
        $prefisso = $this->prefissi_mobile[array_rand($this->prefissi_mobile)];
        $numero = rand(1000000, 9999999);

        $numero_completo = $prefisso . $numero;

        return $prefisso ? "+39 {$numero_completo}" : $numero_completo;
    }
        
}