<?php

namespace Core\Database;
use Core\GruGru;
use Core\Interface\DatabaseInterface;
use PDO;
use PDOException;

class DatabaseSqlite implements DatabaseInterface
{
    protected $pdo;
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

    }
    public function bind($param, $value, $type = null)
    {

    }
    public function executeQuery() 
    {

    }
    public function resultSet()
    {

    }
    public function resultSetArray()
    {

    }
    public function resultSetColumn()
    {

    }
    public function singleRow()
    {

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