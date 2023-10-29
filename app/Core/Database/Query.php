<?php

namespace Core\Database;

class Query
{
    protected string $table;
    protected string $campi = '*';
    protected array $where = [];
    protected string $ordine = '';
    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function campi(string $campi = '*')
    {
        $this->campi = $campi;
        return $this;
    }

    public function where(string $colonna, string $operatore, string $valore)
    {
        $this->where[] = [
            'tipo' => 'AND',
            'colonna' => $colonna,
            'operatore' => $operatore,
            'valore' => $valore
        ];
        return $this;
    }

    public function orWhere(string $colonna, string $operatore, string $valore)
    {
        $this->where[] = [
            'tipo' => 'OR',
            'colonna' => $colonna,
            'operatore' => $operatore,
            'valore' => $valore
        ];
        return $this;        
    }

    public function ordine(string $campo, string $direzione = 'ASC')
    {
        $this->ordine = "ORDER BY {$campo} {$direzione}";
        return $this;
    } 

    public function select()
    {
        $sql = "SELECT {$this->campi} FROM {$this->table}";
        if(!empty($this->where))
        {
            $sql .= ' WHERE ';
            foreach($this->where as $indice => $dove)
            {
                if($indice > 0)
                {
                    $sql .= $dove['tipo']. ' ';
                }
                $sql .= $dove['colonna']. ' '
                . $dove['operatore']
                . ' ?';
            }
        }
    }

    public function insert()
    {
        $valori = str_replace(",", " ", trim($this->campi));
        return trim("INSERT INTO {$this->table} ({$this->campi}) VALUES (:{$valori})");
    }

    public function update()
    {

    }

    public function delete(string $chiave)
    {
        return trim("DELETE FROM {$this->table} WHERE {$chiave} = :chiave");
    }
}