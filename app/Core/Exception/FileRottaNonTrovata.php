<?php

class FileRottaNonTrovata extends \Exception
{
    protected $message = 'Il file contenete le rotte non è stato trovato verifica';
    protected $code = 404;

}
