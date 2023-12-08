<?php

/**
 * User: GruGru - Mostrillo <3
 * Date: 02/09/2023
 * Time: 10:23
 */

namespace Core;

use Core\Exception\RottaNonTrovata;
use Core\Exception\VistaNonTrovata;
use Core\Http\Request;
use Core\Http\Response;

class Router
{
    private Request $request;
    private Response $response;
    private array $rotte = [];
    private array $metodi_concessi = ['get', 'post', 'put', 'patch', 'delete'];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function rotte()
    {
        return $this->rotte;
    }

    public function get(string $url, $callback)
    {
        $this->setRotta('get', $url, $callback);
    }

    public function post(string $url, $callback)
    {
        $this->setRotta('post', $url, $callback);
    }

    public function put(string $url, $callback)
    {
        $this->setRotta('put', $url, $callback);
    }

    public function delete(string $url, $callback)
    {
        $this->setRotta('delete', $url, $callback);
    }

    public function includi(string $metodi, $url, $callback)
    {
        $elenco = explode('|', $metodi);

        foreach ($elenco as $metodo) {
            if(in_array(strtolower($metodo), $this->metodi_concessi))
            {
                $this->setRotta($metodo, $url, $callback);
            } else {
                throw new RottaNonTrovata('Questa rotta non può essere raggiunta', 400);
            }
        }
    }

    public function qualsiasi($url, $callback)
    {
        foreach($this->metodi_concessi as $metodo)
        {
            $this->setRotta($metodo, $url, $callback);
        }
    }

    public function risolvi()
    {
        $metodo = $this->request->getRequestMethod();
        $path = $this->request->getRequestPath();
        $callback = $this->rotte[$metodo][$path] ?? false;

        if(!$callback)
        {
            $callback = $this->getCallback();

            if($callback === false)
            {
                throw new RottaNonTrovata();
            }
        }

        if(is_string($callback))
        {
            return $this->renderView($callback);
        }

        if(is_array($callback))
        {
            $callback[0] = new $callback[0]();
        }

        return  call_user_func($callback, $this->request, $this->response);
    }

    public function renderView(string $vista)
    {
        if(!file_exists('../app/views/' . $vista . '.php'))
        {
            throw new VistaNonTrovata();
        }

        include_once '../app/views/'.$vista.'.php';
    }

    private function setRotta(string $tipo, string $url, $callback)
    {
        $this->rotte[$tipo][$url] = $callback;
    }

    private function getCallback()
    {
        $metodo = $this->request->getRequestMethod();
        $url = $this->request->getRequestPath();

        $url = trim($url, '/');

        $rotte = $this->rotte[$metodo] ?? [];

        $parametriDelleRotte = false;

        foreach($rotte as $rotta => $callback)
        {
            $rotta = trim($rotta, '/');
            $rottaNomi = [];

            if(!$rotta)
            {
                continue;
            }

            if(preg_match_all('/\{(\w+)(:[^}]+)?}/', $rotta, $corrispondenze))
            {
                $rottaNomi = $corrispondenze[1]; 

            }

            $rotteRegEx = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $rotta) . "$@";

            if(preg_match_all($rotteRegEx, $url, $valueMatches))
            {
                $values = [];
                for($i = 1; $i < count($valueMatches); $i++)
                {
                    $values[] = $valueMatches[$i][0];
                } 
                $parametriDelleRotte = array_combine($rottaNomi, $values);

                $this->request->setRouteParams($parametriDelleRotte);
                return $callback;
            }

        }

        return false;
    }

}