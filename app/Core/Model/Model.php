<?php
namespace Core\Model;

use Core\Database\Database;
use Core\Database\Query;
use Core\Exception\RecordNonTrovato;
use Core\GruGru;

abstract class Model
{
    /** @var Database $db */
    public Database $db;

    /** @var Query $query */
    protected Query $query;
    const REGOLA_RICHIESTO = 'request';
    const REGOLA_TESTO = 'text';
    const REGOLA_MAX = 'max';
    const REGOLA_MIN = 'min';
    const REGOLA_NUMERO = 'numeric';
    const REGOLA_EMAIL = 'email';
    const REGOLA_REGEXP = 'regexp';
    private array $errori = [];
    protected string $tabella = '';
    protected string $chiavePrimaria = 'id';
    public function __construct()
    {
        $this->db = GruGru::$APP->db;
        $this->query = new Query;

        if(!$this->tabella)
        {
            $this->tabella = str_replace('model', '', strtolower((new \ReflectionClass($this))->getShortName()));
        }
    }
    abstract public function regole(): array;
    abstract public function etichette(): array;
    abstract protected function campi(): array;
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
                    $this->addErrorByRule($campo, self::REGOLA_RICHIESTO);
                }

                #Valido campo email
                if ($nomeRegola === self::REGOLA_EMAIL && !filter_var($valoreCampo, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($campo, self::REGOLA_EMAIL);
                }

                #Valido campo Numerico
                if ($nomeRegola === self::REGOLA_NUMERO && !filter_var($valoreCampo, FILTER_VALIDATE_INT)) {
                    $this->addErrorByRule($campo, self::REGOLA_NUMERO);
                }

                #Valido campo con un minimo di lunghezza
                if ($nomeRegola === self::REGOLA_MIN && (strlen($valoreCampo) < $regola['min'] || $valoreCampo < $regola['min'])) {
                    $this->addErrorByRule($campo, self::REGOLA_MIN, ['min' => $regola['min']]);
                }

                #Valido campo con un massimo di lunghezza
                if ($nomeRegola === self::REGOLA_MAX && strlen($valoreCampo) > $regola['max']) {
                    $this->addErrorByRule($campo, self::REGOLA_MAX, ['max' => $regola['max']]);
                }

            }
        }
        return empty($this->errori);
    }

    public function aggiungiErrore(string $chiave, string $errore): void
    {
        $this->errori[$chiave] = $errore;
    }

    private function addErrorByRule(string $attribute, string $rule, $params = [])
    {
        $params['field'] ??= $attribute;
        $errorMessage = $this->messaggioDiErrore($rule);
        
        foreach ($params as $key => $value) 
        {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }

        $this->errori[$attribute][] = $errorMessage;
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
        return $this->tabella;
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

    public function tutto(string $campi = '*', ?string $ordine = null, int $limita = 100)
    {
        $ordine = is_null($ordine) ? $this->chiavePrimaria : $ordine;

        $sql = $this->query->table($this->tabella)
        ->campi($campi)
        ->ordine($ordine, 'DESC')->limita($limita)
        ->select();

        $this->db->query($sql);
        return $this->db->resultSet();
    }

    public function trovaPerChiavePrimaria(int $id, string $campi = '*')
    {
        $sql = $this->query->table($this->tabella)->campi($campi)->where($this->chiavePrimaria, '=', 'id')->select();

        $this->db->query($sql); 
        $this->db->bind(':id', $id);
        return $this->db->singleRow();

    }

    public function trova(string|int $valore, ?string $chiave = null)
    {
        if(is_null($chiave))
        {
            $chiave = $this->chiavePrimaria;
        }

        //! VERIFICARE perche non si riesce a fare il bind di chiave
        $sql = $this->query->table($this->tabella)->campi($this->campi())->where($chiave, '=', 'valore')->select();

        $this->db->query($sql);
        $this->db->bind(':valore', $valore);
        $this->db->executeQuery();

        $dati = $this->db->singleRow();

        return $dati ? $dati : null;
    }

    public function trovaOppureErrore(string|int $valore, ?string $chiave = null)
    {
        $trova = $this->trova($valore, $chiave) ?? null;

        if (is_null($trova))
        {
            throw new RecordNonTrovato;
        }

        return $trova;
    }

    public function salva()
    {
        $sql = $this->query->table($this->tabella)->campi($this->campi())->insert();
        $this->db->query($sql);

        foreach($this->campi() as $valore)
        {
            #Bind valore
            $this->db->bind(":$valore", $this->{$valore});
        }

        return $this->db->executeQuery();
    }

    /**
     * Aggiorna i dati nel database
     * @param int|string $id
     * @return bool
     */
    public function aggiorna(string|int $id):bool
    {
        $sql = $this->query->table($this->tabella)->campi($this->campi())->update($this->chiavePrimaria);
        $this->db->query($sql);

        foreach($this->campi() as $valore)
        {
            #Bind valori
            $this->db->bind(":$valore", $this->{$valore});
        }

        $this->db->bind(":$this->chiavePrimaria", $id);

        return $this->db->executeQuery();
    }

    /**
     * Elimina un record dal database usando la chiave primaria
     *
     * @param integer $id
     * @return bool
     */
    public function elimina(int $id): bool
    {
        $sql = $this->query->table($this->tabella)
        ->delete($this->chiavePrimaria);

        $this->db->query($sql);
        $this->db->bind(':'.$this->chiavePrimaria, $id);
        
        return $this->db->executeQuery();
    }
}