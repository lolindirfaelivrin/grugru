<?php

namespace Core\Database;

class Query
{
    protected string $table;
    protected string $campi = '*';
    protected array $where = [];
    protected string $limita = '';
    protected string $ordine = '';
    protected string $sql = '';
    public function table(string $table): Query
    {
        $this->table = $table;
        return $this;
    }

    public function campi(string|array $campi = '*'): Query
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

    public function ordine(string $campo, string $direzione = 'ASC'): Query
    {
        $this->ordine = "ORDER BY {$campo} {$direzione}";
        return $this;
    } 

    public function andOrdine(array|string $ordine):Query
    {
        if(is_string($ordine))
        {
            $this->ordine = "ORDER BY {$ordine}";
            return $this;
        }

        $sql = 'ORDER BY';
        foreach($ordine as $ordina => $ordinamento)
        {
            $sql .= " {$ordina} {$ordinamento},";
        }

        $this->ordine = rtrim($sql, ',');
        return $this;
    }

    public function limita(int $limite, ?int $offset = null): Query
    {
        $this->limita = "LIMIT {$limite}";

        if(!is_null($offset))
        {
            $this->limita = "LIMIT {$limite} OFFSET {$offset}";
        }

        return $this;
    }

    public function select(): string
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

        $this->sql = $sql; 
        $this->svuotaQuery();
        return $sql;
    }

    public function insert()
    {
        $valori = ':' . implode(',:', explode(',', $this->campi));
   
        $sql =  trim("INSERT INTO {$this->table} ({$this->campi}) VALUES ({$valori})");

        $this->sql = $sql;
        $this->svuotaQuery();
        return $sql;
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

        $this->sql = $sql;
        $this->svuotaQuery();
        return $sql;

    }

    public function delete(string|int $chiave)
    {
        $sql =  trim("DELETE FROM {$this->table} WHERE {$chiave} = :{$chiave}");

        $this->sql = $sql;
        $this->svuotaQuery();
        return $sql;
    }

    private function svuotaQuery(): void
    {
        $elementi = ['table', 'campi', 'where', 'limita', 'ordine'];

        foreach($elementi as $elemento)
        {
            if(is_string($this->{$elemento}))
            {
                $this->{$elemento} = '';
            }
            if(is_array($this->{$elemento}))
            {
                $this->{$elemento} = [];
            }
        }
    }

    public function __toString():string
    {
        return 'QUERY => '.$this->sql;
    }
}