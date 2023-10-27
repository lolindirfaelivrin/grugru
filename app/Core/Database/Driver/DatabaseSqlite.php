<?php

namespace Core\Database\Driver;
use Core\GruGru;
use Core\Interface\DatabaseInterface;
use PDO;
use PDOException;

class DatabaseSqlite implements DatabaseInterface
{
    protected $pdo;
    protected $statement;
    public function __construct($configurazione)
    {
        try {
            $this->pdo = $this->connetti($configurazione);
        } catch (PDOException $e) {
            dd($e->getMessage());
        }
    }

    public function connetti($configurazione)
    {
        if ($this->pdo == null) {
            $this->pdo = new PDO("sqlite:" . GruGru::$ROOTDIR.'/database/'.$configurazione['database']);
        }
        return $this->pdo;
    }
    public function query($sql)
    {
        $this->statement = $this->pdo->prepare($sql);
    }
    public function bind($param, $value, $type = null)
    {

    }
    public function executeQuery() 
    {
        return $this->statement->execute();
    }
    public function resultSet()
    {
        $this->executeQuery();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }
    public function resultSetArray()
    {

    }
    public function resultSetColumn()
    {

    }
    public function singleRow()
    {
        $this->executeQuery();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }
    public function rowCount()
    {

    }
    public function mostraErrore()
    {

    }
    public function lastId()
    {

    }

}