<?php
namespace Core\Exception;
class NonAutorizzato extends \Exception
{
    protected $message = 'Non sei autorizzato a visualizzare questa pagina';
    protected $code = 403;
}