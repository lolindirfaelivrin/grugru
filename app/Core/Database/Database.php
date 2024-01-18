<?php

namespace Core\Database;
use Core\Interface\DatabaseInterface;

class Database
{
    private DatabaseInterface $db;
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    public function bind($param, $value, $type = null) 
    {
        return $this->db->bind($param, $value, $type);
    }

    public function executeQuery()
    {
        return $this->db->executeQuery();
    }

    public function resultSet()
    {
        return $this->db->resultSet();
    }

    public function singleRow()
    {
        return $this->db->singleRow();
    }

    public function lastId()
    {
        return $this->db->lastId();
    }

    public function rowCount()
    {
        return $this->db->rowCount();
    }

    public function iniziaTransazione()
    {
       return $this->db->iniziaTransizione();
    }

    public function fineTransizione()
    {
        return $this->fineTransizione();
    }

    public function cancellaTransizione()
    {
        return $this->cancellaTransizione();
    }

    public function info()
    {
        return $this->db->info();
    }


}