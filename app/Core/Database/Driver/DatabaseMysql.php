<?php

namespace Core\Database\Driver;
use Core\Interface\DatabaseInterface;
use PDO;
use PDOException;

class DatabaseMysql implements DatabaseInterface
{

  private $dbHost;
  private $dbUser;
  private $dbPass;
  private $dbName;

  private $statement;
  private $dbHandler;
  private $dberror;

  protected ?PDO $pdo = null;

  public function __construct(protected array $configurazione)
  {
    $this->dbHost = $configurazione['host'];
    $this->dbUser = $configurazione['user'];
    $this->dbPass = $configurazione['password'];
    $this->dbName = $configurazione['database'];

    $conn = "mysql:host={$this->dbHost};dbname={$this->dbName}";

    $this->dbHandler = $this->connetti($conn);
  }

  public function connetti($configurazione):?PDO
  {

    $options = [
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      return new PDO($configurazione, $this->dbUser, $this->dbPass, $options);
    } catch (PDOException $e) {
      $this->dberror = $e->getMessage();
      echo $this->dberror;
    }

  }

  public function query($sql) 
  {
    $this->statement = $this->dbHandler->prepare($sql);
  }

  public function bind($param, $value, $type = null) 
  {
    switch (is_null($type)) {

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
    $this->executeQuery();
    return $this->statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function resultSetColumn()
  {
    $this->executeQuery();
    return $this->statement->fetchAll(PDO::FETCH_COLUMN);
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
    return $this->statement->errorInfo();
  }

  public function lastId() 
  {
    return $this->dbHandler->lastInsertId();
  }

  public function iniziaTransizione()
  {
    return $this->dbHandler->beginTransaction();
  }

  public function fineTransizione()
  {
    return $this->dbHandler->commit();
  }

  public function cancellaTransizione()
  {
    return $this->dbHandler->rollBack();
  }

  public function info(): array
  {
    $output = [
      'server' => 'SERVER_INFO',
      'driver' => 'DRIVER_NAME',
      'client' => 'CLIENT_VERSION',
      'version' => 'SERVER_VERSION',
      'connection' => 'CONNECTION_STATUS'
    ];

    foreach ($output as $key => $value) {
      try {
        $output[$key] = $this->pdo->getAttribute(constant('PDO::ATTR_' . $value));
      } catch (PDOException $e) {
        $output[$key] = $e->getMessage();
      }
    }



    $output['dsn'] = $this->configurazione['database'];
    $output['transaction attive'] = (bool) $this->pdo->query('PRAGMA foreign_keys;')->fetchColumn(0);

    return $output;
  }

}


