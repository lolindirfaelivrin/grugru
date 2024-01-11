<?php
namespace Core\Middlewear;
use Core\GruGru;
class AccessoMiddlewear extends Middlewear
{
    public array $azioni = [];

    public function __construct(array $azioni = [])
    {
        $this->azioni = $azioni;
    }
    public function esegui()
    {
        if(empty($this->azioni) || in_array(GruGru::$APP->controller->azione, $this->azioni))
        {
            dump('Accesso');
        }

    }

}