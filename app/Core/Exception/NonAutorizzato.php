<?php
namespace Core\Exception;
class NotTrovato extends \Exception
{
    protected $message = 'Non sei autorizzato a visualizzare questa pagina';
    protected $code = 403;
}