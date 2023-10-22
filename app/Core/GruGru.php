<?php

/**
 * User: GruGru - Mostrillo <3
 * Date: 02/09/2023
 * Time: 10:23
 */

namespace Core;
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
    #public Database $db;
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
        #$this->db = new Database($this->configurazione->ottieni('connection.mysql'));

        self::$APP = $this;
        self::$ROOTDIR = dirname(__DIR__);

    }

    public function configurazione()
    {
        echo '<pre>';
        var_dump($this->config);
        echo '</pre>';
    }

}