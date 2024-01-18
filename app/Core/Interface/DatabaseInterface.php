<?php
namespace Core\Interface;
interface DatabaseInterface
{
    public function connetti($configurazione);
    public function query($sql);
    public function bind($param, $value, $type = null);
    public function executeQuery();
    public function resultSet();
    public function resultSetArray();
    public function resultSetColumn();
    public function singleRow();
    public function rowCount();
    public function mostraErrore();
    public function lastId();
    public function iniziaTransizione();
    public function fineTransizione();
    public function cancellaTransizione();

}