<?php

declare(strict_types=1);

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
use Libreria\Falsifica\Falsifica;


/** @package Core */
final class GruGru
{
    public static GruGru $APP;
    public static string $ROOTDIR;

    private const string VERSIONE_MINIMA_PHP = '8.3.0';

    public static string $VERSIONE = '0.3.2';
    public static array $FILE_ROTTE_REGISTRATE = [];

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

    public function __construct(string $rootdir, array $config = [])
    {
        self::$APP = $this;
        self::$ROOTDIR = $rootdir ?? dirname(__DIR__);

        #Oppure posso instanziare direttamente qui le classi
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->rotte = new RouterGestore();
        $this->controller = new Controller();
        $this->session = new Session();
        $this->config = $config ?? $this->creaConfigurazione();
        $this->configurazione = new Config($this->config);
        $this->vista = new Vista();
        $this->db = new Database($this->ottieniTipoDatabase($this->configurazione->ottieni('default')));

        self::$FILE_ROTTE_REGISTRATE = [];
    }

    /**
     * @param string|array $rotta 
     * @return GruGru 
     */
    public function registraFileRotta(string|array $rotta = 'web'): GruGru
    {
        $this->rotte->registraRotta($rotta);
        self::$FILE_ROTTE_REGISTRATE = $this->rotte->rotteRegistrate();

        return $this;
    }

    /**
     * @return GruGru 
     */
    public function verificaVersioneMinimaPHP(): GruGru
    {
        $versione_minima_php = self::VERSIONE_MINIMA_PHP;
        if (version_compare(PHP_VERSION, $versione_minima_php, '<')) {
            throw new \Exception("La versione minima di PHP richiesta è {$versione_minima_php}. La versione attuale è " . PHP_VERSION);
        }
        return $this;
    }

    /**
     * @param string|array|null $verifica_ambiente 
     * @return string|bool 
     */
    public static function ambiente(string|array|null $verifica_ambiente = null): string|bool
    {
        if (\is_string($verifica_ambiente)) {
            return self::$APP->configurazione->ottieni('app.env') === $verifica_ambiente;
        }

        if (\is_array($verifica_ambiente)) {
            return \in_array(self::$APP->configurazione->ottieni('app.env'), $verifica_ambiente);
        }

        return self::$APP->configurazione->ottieni('app.env');
    }

    /**
     * @return GruGru 
     */
    public function gestisciErrori(): GruGru
    {
        if ($this->configurazione->ottieni('app.debug') && self::ambiente('locale')) {
            ini_set('display_errors', '1');
            error_reporting(E_ALL);
            $this->gestioneEccezioni();
            $this->gestioneErrori();
        } else {
            ini_set('display_errors', '0');
            error_reporting(0);
        }

        return $this;
    }

    /**
     * Si occupa di registrare i providers contenuti nella cartella provider. 
     * I providers sono classi che forniscono servizi o funzionalità specifiche all'applicazione.
     * @return GruGru
     */
    public function registraProviders(): GruGru
    {
        $percorso_providers = self::$ROOTDIR . '/app/provider';

        foreach (glob(rtrim($percorso_providers, '/') . '/*.php') as $file) {
            $fornitore = require $file;

            if (!is_array($fornitore)) {
                throw new \RuntimeException(sprintf('Il file provider "%s" deve ritornare un array.', $file));
            }

            foreach ($fornitori as $fornitore => $fabbrica) {
                Falsifica::registraFornitore($fornitore, $fabbrica);
            }
        }


        return $this;
    }

    /**
     * @return void
     */
    private function gestioneEccezioni(): void
    {
        set_exception_handler(array("Core\Exception\GestisciEccezioni", "getStaticException"));
    }

    /**
     * @return void
     */
    private function gestioneErrori(): void
    {
        set_error_handler(array("Core\Exception\GestisciErrori", "getStaticError"));
    }

    /**
     * @param string $driver
     * @return DatabaseInterface
     */
    private function ottieniTipoDatabase(string $driver): DatabaseInterface
    {
        //TODO: Guarda il codice generato da chatGpt.
        $driver;
        switch ($driver) {
            case 'sqlite':
                $driver = new DatabaseSqlite($this->configurazione->ottieni('database.connection.sqlite'));
                break;

            case 'mysql':
                $driver = new DatabaseMysql($this->configurazione->ottieni('connection.mysql'));
                break;

            default:
                $driver = new DatabaseMysql($this->configurazione->ottieni('database.connection.mysql'));
                break;
        }

        return $driver;
    }

    /**
     * @return array
     */
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
