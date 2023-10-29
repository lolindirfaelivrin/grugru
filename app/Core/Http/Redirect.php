<?php

namespace Core\Http;
use Core\Http\enum\HttpstatusCode;

class Redirect extends Response
{
    public function __construct(string $url)
    {
        parent::__construct('', HttpstatusCode::Redirect, ['location' => $url] );

    }

    public function conMessaggio()
    {
        
    }

    public function invia()
    {
        return header('Location'.$this->header['location'], true, $this->codice->value);
    }
}