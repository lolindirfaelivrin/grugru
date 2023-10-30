<?php

namespace Core\Http;
use Core\Http\enum\HttpstatusCode;
use Libreria\Flash;

class Redirect extends Response
{
    public function __construct(string $url = '')
    {
        parent::__construct('', HttpstatusCode::Redirect, ['location' => $url] );

    }

    public function url(string $url)
    {
        $this->setHeader(['location' ,$url]);
        return $this;
    }

    public function conMessaggio(string $indice, string $messaggio)
    {
         (new Flash())->aggiungi( $indice, $messaggio );

         return $this;

    }

    public function vai()
    {
        return header('Location: '.$this->header['location'], true, $this->codice->value);
    }
}