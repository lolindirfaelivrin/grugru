<?php

namespace Core\Http;

class Request
{
    private string $metodo = '__method';

    private array $routeParams = [];

    public function getRequestMethod()
    {
        if(isset($_POST[$this->metodo]) && in_array($_POST[$this->metodo], ['delete', 'put', 'patch']))
        {
            return $_POST[$this->metodo];
        }
        
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getRequestPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if($position === false)
        {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function isGet():bool
    {
        return $this->getRequestMethod() === 'get';
    }

    public function isPost(): bool
    {
        return $this->getRequestMethod() === 'post';
    }

    public function getBody()
    {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }

    public function typeIs(string $tipo_di_richiesta): bool
    {
        return $this->getRequestMethod() === strtolower($tipo_di_richiesta);
    }

    public function setRouteParams($params)
    {
        $this->routeParams = $params;
        return $this;
    }

    public function getRouteParams()
    {
        return $this->routeParams;
    }

    public function getRouteParam($param, $default = null)
    {
        return $this->routeParams[$param] ?? $default;
    }

    public function getRouteParamsNames()
    {
        return array_keys($this->routeParams);
    }

}