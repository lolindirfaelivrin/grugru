<?php

/**
 * User: GruGru - Mostrillo <3
 * Date: 02/09/2023
 * Time: 10:23
 */

namespace Core;
use Core\Database\DatabaseMysql;
use Core\Database\DatabaseSqlite;
use Core\Http\Request;
use Core\Http\Response;
use Core\Database\Database;
use Core\Controller\Controller;
class GruGru
{
    public static GruGru $APP;
    public static $ROOTDIR;
    public static string $VERSIONE = '0.3.1';

    private array $config;

    public Request $request;
    public Response $response;
    public Router $router;
    public DatabaseMysql $db;
    public Session $session;
    #public Controller $controller;
    public Config $configurazione;
    public Vista $vista;

    public function __construct(string $rootdir, array $config)
    {
        #Oppure posso instanziare direttamente qui le classi
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        #$this->controller = new Controller($this->response, $this->request);
        $this->session = new Session();
        $this->config = $config;
        $this->configurazione = new Config($config);
        $this->vista = new Vista();
        $this->db = new DatabaseMysql($this->configurazione->ottieni('connection.mysql'));
        dd($this->db);

        self::$APP = $this;
        self::$ROOTDIR = dirname(__DIR__);

    }

    public function configurazione()
    {
        echo '<pre>';
        var_dump($this->config);
        echo '</pre>';
    }

    private function ottieniTipoDatabase(string $driver)
    {
        $driver = '';
        switch ($driver)
        {
            case 'sqlite':
            $driver =  DatabaseSqlite::class;
            break;

            case 'mysql':
            $driver = DatabaseMysql::class;
            break;

            default:
            $driver = DatabaseMysql::class;
            break;
        }    

        return $driver;
    }

}