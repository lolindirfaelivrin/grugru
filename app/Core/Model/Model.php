<?php
namespace Core\Model;

use Core\Database\Database;
use Core\GruGru;

abstract class Model
{
    /** @var Database $db */
    public Database $db;
    public function __construct()
    {
        $this->db = GruGru::$APP->db;
    }
    const REGOLA_RICHIESTO = 'request';
    const REGOLA_TESTO = 'text';
    const REGOLA_MAX = 'max';
    const REGOLA_MIN = 'min';
    const REGOLA_NUMERO = 'numeric';
    const REGOLA_EMAIL = 'email';
    const REGOLA_REGEXP = 'regexp';
    private array $errori = [];
    abstract public function regole(): array;
    abstract public function etichette(): array;
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function valida()
    {
        foreach ($this->regole() as $campo => $regole) {
            $valoreCampo = $this->{$campo};
            foreach ($regole as $regola) {
                $nomeRegola = $regola;
                if (!is_string($regola)) {
                    $nomeRegola = $regola[0];
                }

                #Valido campo richiesto
                if ($nomeRegola === self::REGOLA_RICHIESTO && vuoto($valoreCampo)) {
                    $this->aggiungiErrore($campo, self::REGOLA_RICHIESTO);
                }

                #Valido campo email
                if ($nomeRegola === self::REGOLA_EMAIL && !filter_var($valoreCampo, FILTER_VALIDATE_EMAIL)) {
                    $this->aggiungiErrore($campo, self::REGOLA_EMAIL);
                }

                #Valido campo Numerico
                if ($nomeRegola === self::REGOLA_NUMERO && !filter_var($valoreCampo, FILTER_VALIDATE_INT)) {
                    $this->aggiungiErrore($campo, self::REGOLA_NUMERO);
                }

                #Valido campo con un minimo di lunghezza
                if ($nomeRegola === self::REGOLA_MIN && (strlen($valoreCampo) < $regola['min'] || $valoreCampo < $regola['min'])) {
                    $this->aggiungiErrore($campo, self::REGOLA_MIN);
                }

                #Valido campo con un massimo di lunghezza
                if ($nomeRegola === self::REGOLA_MAX && strlen($valoreCampo) > $regola['max']) {
                    $this->aggiungiErrore($campo, self::REGOLA_MAX);
                }

            }
        }
        return empty($this->errori);
    }

    public function aggiungiErrore(string $chiave, string $errore): void
    {
        $this->errori[$chiave] = $errore;
    }

    public function primoErrore(string $chiave): string
    {
        if (array_key_exists($chiave, $this->errori)) {
            return $this->errori[$chiave][0];
        }

        return '';
    }

    public function getTabella()
    {
        return 'tabella';
    }

    public function errori(): array
    {
        return $this->errori;
    }

    public function messaggiDiErrore(): array
    {
        return [
            self::REGOLA_RICHIESTO => 'Questo campo è richiesto',
            self::REGOLA_TESTO => 'Questo campo deve essere un testo',
            self::REGOLA_MAX => 'Questo campo non può essere più lungo di {max} caratteri',
            self::REGOLA_MIN => 'Questo campo non può essere più piccolo di {min} caratteri',
            self::REGOLA_NUMERO => 'Questo campo deve essere un numero',
            self::REGOLA_EMAIL => 'Questo campo deve essere una email',
            self::REGOLA_REGEXP => 'Questo campo non rispetta il formato'
        ];

    }

    public function messaggioDiErrore(string $regola): string
    {
        return $this->messaggiDiErrore()[$regola];
    }

    public function haErrore(string $campo): bool
    {
        return $this->errori[$campo] ?? false;
    }
}