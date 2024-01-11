<?php

namespace Core\Database;

class Query
{
    protected string $table;
    protected string $campi = '*';
    protected array $where = [];
    protected string $limita;
    protected string $ordine = '';
    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function campi(string|array $campi = '*')
    {
        if(is_array($campi))
        {
            $this->campi = implode(',', $campi);
            return $this;
        }
        
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

    public function limita(int $limite, int $offset = 10)
    {
        $this->limita = "LIMIT {$limite}";
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
                . " :{$dove['valore']}";
            }
        }

        if(!empty($this->ordine))
        {
            $sql .= " {$this->ordine}";
        } 
        if(!empty($this->limita))
        {
            $sql .= " {$this->limita}";
        } 

        return $sql;
    }

    public function insert()
    {
        $valori = ':' . implode(',:', explode(',', $this->campi));
   
        return trim("INSERT INTO {$this->table} ({$this->campi}) VALUES ({$valori})");
    }

    public function update(string $chiave):string
    {
        $campi = explode(',', $this->campi);
        $sql = "UPDATE {$this->table} SET ";

        foreach($campi as $campo)
        {
            $sql .= " {$campo} = :{$campo}, ";
        }

        $sql = rtrim($sql, ', ');

        $sql .= " WHERE $chiave = :{$chiave}";

        return $sql;

    }

    public function delete(string|int $chiave)
    {
        return trim("DELETE FROM {$this->table} WHERE {$chiave} = :{$chiave}");
    }
}