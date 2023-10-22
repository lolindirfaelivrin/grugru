<?php
namespace Core\Exception;

class ErroreFatale extends \Exception
{
    protected $message = 'Errore FATALE interno del server';
    protected $code = 500;
}