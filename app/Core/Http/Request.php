<?php

namespace Core\Http;

class Request
{
    private string $metodo = '__method';

    public function getRequestMethod()
    {
        if(isset($_POST[$this->metodo]) && in_array($_POST[$this->metodo], ['delete', 'put']))
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

}