<?php

namespace Core\Http;
use Core\Http\enum\HttpstatusCode;

class Response
{
    public function __construct(protected mixed $risposta = '', protected HttpstatusCode $codice = HttpstatusCode::OK, protected array $header = [])
    {}
    public function setHttpCode(HttpstatusCode $codice)
    {
        http_response_code($codice->value);
        
        return $this;
    }

    public function setHeader(array $header)
    {
        $this->header = $header;

        foreach($header as $indice => $valore)
        {
            header("$indice:$valore");
        }

        return $this;
    }

    public function indirizza(string $url)
    {
        header("Location: $url");
    }

    public function esci($dati, HttpstatusCode $codice = HttpstatusCode::ErroreInterno)
    {
        $this->setHttpCode($codice);
        if(is_array($dati))
        {
            header('Content-Type:application/json');
            $dati = json_encode($dati);
        }
        echo $dati;
        exit;
    }

    protected function invia(mixed $risposta)
    {
        echo (in_array('application/json', $this->header)) ?
            json_encode($risposta) :
            $risposta;
    }
    
}