<?php

/**
 * User: GruGru - Mostrillo <3
 * Date: 02/09/2023
 * Time: 10:23
 */

namespace Core;
use Core\Database\Driver\DatabaseMysql;
use Core\Database\Driver\DatabaseSqlite;
use Core\Http\Request;
use Core\Http\Response;
use Core\Database\Database;
use Core\Controller\Controller;
use Core\Interface\DatabaseInterface;
class GruGru
{
    public static GruGru $APP;
    public static $ROOTDIR;
    public static string $VERSIONE = '0.3.2';

    private array $config;

    public Request $request;
    public Response $response;
    public Router $router;
    public Database $db;
    public Session $session;
    public Controller $controller;
    public Config $configurazione;
    public Vista $vista;

    public function __construct(string $rootdir, array $config)
    {
        self::$APP = $this;
        self::$ROOTDIR = dirname(__DIR__);
        
        #Oppure posso instanziare direttamente qui le classi
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->controller = new Controller();
        $this->session = new Session();
        $this->config = $config;
        $this->configurazione = new Config($config);
        $this->vista = new Vista();
        $this->db = new Database($this->ottieniTipoDatabase($this->configurazione->ottieni('default')));


    }

    public function configurazione()
    {
        echo '<pre>';
        var_dump($this->config);
        echo '</pre>';
    }

    private function ottieniTipoDatabase(string $driver)
    {
        //TODO: Guarda il codice generato da chatGpt.
        $driver;
        switch ($driver)
        {
            case 'sqlite':
            $driver =  new DatabaseSqlite($this->configurazione->ottieni('connection.sqlite'));
            break;

            case 'mysql':
            $driver = new DatabaseMysql($this->configurazione->ottieni('connection.mysql'));
            break;

            default:
            $driver = new DatabaseMysql($this->configurazione->ottieni('connection.mysql'));
            break;
        }    

        return $driver;
    }

}