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

    /**
     * Restituisce il valore di uno specifico campo di input di una richiesta POST
     *
     * @param string $input Campo input da cercare
     * @param string|null $predefinito Valore opzionale che viene restituito
     * @return string|null
     */
    public function input(string $input, ?string $predefinito = null):?string
    {
        if(isset($_POST[$input]))
        {
            return filter_input(INPUT_POST, $input, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $predefinito;
    }

    public function solamente(string|array $parametri)
    {
        $data = [];

        if(is_string($parametri))
        {
            $parametri = explode(',', $parametri);
        }

        if($this->isPost())
        {
            foreach($_POST as $chiave => $valore)
            {
                if(in_array($valore, $parametri))
                {
                    $data[$chiave] = $valore;
                }
            }
        }
        return $data;
    }

    /**
     * Determina se un valore è presente nella richiesta e non è una stringa vuota.
     *
     * @param string $campo La chiave del valore da controllare nella richiesta.
     * @return boolean se il valore è presente e non è una stringa vuota, altrimenti false.
     */
    public function compilato(string $campo):bool
    {
        return (isset($_POST[$campo]) && !vuoto($_POST[$campo]));
    }

    /**
     * Determina se un valore è presente nella richiesta.
     * 
     * Questo metodo restituisce true se il valore è presente nella richiesta.
     * Quando viene fornito un array, il metodo determina se tutti i valori specificati sono presenti.
     *
     * @param string|array $campo La chiave o l'array di chiavi da controllare nella richiesta.
     * @return boolean True se il valore o tutti i valori specificati sono presenti, altrimenti false.
     */
    public function presente(string|array $campo):bool
    {
        if(is_string($campo))
        {
            return isset($_POST[$campo]);
        }

        if(is_array($campo))
        {
            $presente = true;
            foreach($campo as $elemento)
            {
                if(!isset($_POST[$elemento]))
                {
                    $presente = false;
                }
            }

            return $presente; 
        }

        return false;
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

    public function files(array|string $nomefile = null)
    {
        if($nomefile == null)
        {
            return $_FILES;
        }

        if(is_string($nomefile))
        {
            return $_FILES[$nomefile] ?? null;
        }

        $files = [];
        foreach($nomefile as $file)
        {
            $files[$file] = $_FILES[$file] ?? null; 

        }

        return $files;
    }

}