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
use Core\Vista\Vista;


class GruGru
{
    public static GruGru $APP;
    public static $ROOTDIR;

    private const string VERSIONE_MINIMA_PHP = '8.3.0';

    public static string $VERSIONE = '0.3.2';
    public static array $ROTTE_REGISTRATE = [];

    private array $config;

    public Request $request;
    public Response $response;
    public Router $router;
    public Database $db;
    public Session $session;
    public Controller $controller;
    public Config $configurazione;
    public Vista $vista;
    public RouterGestore $rotte;

    public function __construct(string $rootdir, array $config)
    {
        self::$APP = $this;
        self::$ROOTDIR = dirname(__DIR__);

        #Oppure posso instanziare direttamente qui le classi
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->rotte = new RouterGestore();
        $this->controller = new Controller();
        $this->session = new Session();
        $this->config = $config;
        $this->configurazione = new Config($config);
        $this->vista = new Vista();
        $this->db = new Database($this->ottieniTipoDatabase($this->configurazione->ottieni('default')));

        self::$ROTTE_REGISTRATE = $this->rotte->rotteRegistrate();

    }

    public function registraFileRotta(string|array $rotta = 'web'): void
    {
        $this->rotte->registraRotta($rotta);
    }

    public function verificaVersioneMinimaPHP(): GruGru
    {
        $versione_minima_php = self::VERSIONE_MINIMA_PHP;
        if (version_compare(PHP_VERSION, $versione_minima_php, '<')) {
            throw new \Exception("La versione minima di PHP richiesta è {$versione_minima_php}. La versione attuale è " . PHP_VERSION);
        }
        return $this;
    }

    public static function ambiente(string|array|null $verifica_ambiente = null): string|bool
    {
        if (\is_string($verifica_ambiente)) {
            return env('APP_ENV') === $verifica_ambiente;
        }

        if (\is_array($verifica_ambiente)) {
            return \in_array(env('APP_ENV'), $verifica_ambiente);
        }

        return env('APP_ENV');
    }

    public function gestioneErrori(): GruGru
    {
        if ($this->configurazione->ottieni('app.debug')) {
            ini_set('display_errors', '1');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', '0');
            error_reporting(0);
        }

        return $this;
    }

    public function configurazione()
    {
        echo '<pre>';
        var_dump($this->config);
        echo '</pre>';
        echo '<pre>';
        var_dump($this->router->rotte());
        echo '</pre>';
        echo '<pre>';
        var_dump($this->rotte->rotteRegistrate());
        echo '</pre>';
    }

    private function ottieniTipoDatabase(string $driver)
    {
        //TODO: Guarda il codice generato da chatGpt.
        $driver;
        switch ($driver) {
            case 'sqlite':
                $driver = new DatabaseSqlite($this->configurazione->ottieni('connection.sqlite'));
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

    public function creaConfigurazione(): array
    {
        $configurazione = [];
        $configurazione_directory = self::$ROOTDIR . '/config';

        $file_configurazione = glob(rtrim($configurazione_directory, '/') . '/*.php');

        if ($file_configurazione === false) {
            throw new \Exception("Errore nella lettura dei file di configurazione");
        }

        foreach ($file_configurazione as $file) {
            $nome_file = basename($file, '.php');
            $configurazione[$nome_file] = require $file;
        }

        return $configurazione;
    }


}