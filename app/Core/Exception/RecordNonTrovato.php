<?php
namespace Core\Exception;
class RecordNonTrovato extends \Exception
{
    protected $message = 'Record non trovato';
    protected $code = 404;
    
}