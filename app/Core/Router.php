<?php

/**
 * User: GruGru - Mostrillo <3
 * Date: 02/09/2023
 * Time: 10:23
 */

namespace Core;
use Core\Exception\NonTrovato;
use Core\Exception\RottaNonTrovata;
use Core\Exception\VistaNonTrovata;
use Core\Http\Request;
use Core\Http\Response;

class Router
{
    private Request $request;
    private Response $response;
    private array $rotte = [];

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

    public function risolvi()
    {
        $metodo = $this->request->getRequestMethod();
        $path = $this->request->getRequestPath();
        $callback = $this->rotte[$metodo][$path] ?? false;

        if(!$callback)
        {
            $callback = $this->getCallback();
            throw new RottaNonTrovata();
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

        }

        return $parametriDelleRotte;
    }

}