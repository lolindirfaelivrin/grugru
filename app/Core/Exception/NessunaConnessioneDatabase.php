<?php
namespace Core\Exception;

class NessunaConnessioneDatabase extends \Exception
{
    protected $message = 'Impossibile connettersi al Dataabse';
    protected $code = 403;
}