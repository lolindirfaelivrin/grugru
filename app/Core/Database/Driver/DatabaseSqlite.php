<?php

namespace Core\Database\Driver;
use Core\GruGru;
use Core\Interface\DatabaseInterface;
use PDO;
use PDOException;

class DatabaseSqlite implements DatabaseInterface
{
    protected ?PDO $pdo = null;
    protected $statement;
    public function __construct(protected array $configurazione)
    { 
        try {
            $this->pdo = $this->connetti($configurazione);
            
            if ($configurazione['transaction'])
            { 
                $this->abilitaTransazione();
            }
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
    private function abilitaTransazione():void
    {
        $this->pdo->exec('PRAGMA foreign_keys = ON;');
    }
    public function query($sql)
    {
        $this->statement = $this->pdo->prepare($sql);
    }
    public function bind($param, $value, $type = null)
    {
        switch (is_null($type))
        {

            case is_int($value):
                $type = PDO::PARAM_INT;
                break;

            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;

            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;

            default:
                // code...
                $type = PDO::PARAM_STR;
        }

        $this->statement->bindValue($param, $value, $type);

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
        return $this->statement->rowCount();
    }
    public function mostraErrore()
    {

    }
    public function lastId()
    {
        return $this->pdo->lastInsertId();
    }

    public function iniziaTransizione()
    {
        return $this->pdo->beginTransaction();
    }

    public function fineTransizione()
    {
        return $this->pdo->commit();
    }

    public function cancellaTransizione()
    {
        return $this->pdo->rollBack();
    }

    public function info():array
    {
        $output = [
            'server' => 'SERVER_INFO',
            'driver' => 'DRIVER_NAME',
            'client' => 'CLIENT_VERSION',
            'version' => 'SERVER_VERSION',
            'connection' => 'CONNECTION_STATUS'
        ];

        foreach ($output as $key => $value)
        {
            try
            {
                $output[$key] = $this->pdo->getAttribute(constant('PDO::ATTR_' . $value));
            } 
            catch (PDOException $e) 
            {
                $output[$key] = $e->getMessage();
            }
        }



        $output['dsn'] = $this->configurazione['database'];
        $output['transaction attive'] = (bool) $this->pdo->query('PRAGMA foreign_keys;')->fetchColumn(0);

        return $output;
    }

}