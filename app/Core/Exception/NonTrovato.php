<?php

namespace Core\Exception;

class NonTrovato extends \Exception
{
    protected string $message = 'Pagina non trovata';
    protected int $code = 404;
}