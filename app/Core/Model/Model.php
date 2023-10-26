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
    public const REGOLA_TESTO = 'testo';
    private array $errori = [];
    abstract public function regole():array;
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function aggiungiErrore(string $chiave, string $errore): void
    {
        $this->errori[$chiave] = $errore;
    }

    public function primoErrore(string $chiave): string
    {
        if(array_key_exists($chiave, $this->errori))
        {
            return $this->errori[$chiave][0];
        }

        return '';
    }

    public function getTabella()
    {
        return 'tabella';
    }
}