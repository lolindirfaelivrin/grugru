<?php

namespace Core\Exception;

use Core\Http\enum\HttpstatusCode;

class RottaNonTrovata extends \Exception
{
    protected $message = 'Rotta non trovata, controlla url';
    protected $code = HttpstatusCode::NonTrovato;
}