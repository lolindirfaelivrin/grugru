<?php

namespace Core\Exception;

class  VistaNonTrovata extends \Exception
{
    protected $message = 'Vista non trovata';
    protected $code = 404;
}