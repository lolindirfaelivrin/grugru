<?php
namespace Core\Exception;
use Exception;

class GestisciEccezioni extends Exception
{
    public function __construct($message, $code=NULL)
    {
        parent::__construct($message, $code);
    }
    
    public function __toString()
    {
        return "Codice Errore: " . $this->getCode() . "<br />Message: " . htmlentities($this->getMessage());
    }
    
    public function getException()
    {
        print $this; // This will print the return from the above method __toString()
    }
    
    public static function getStaticException($exception)
    {
         $exception->getException(); // $exception is an instance of this class
    }

}