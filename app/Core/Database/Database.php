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
}