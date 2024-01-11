<?php
namespace Core\Middlewear;

use Core\Exception\NonAutorizzato;
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
        $autenticato = GruGru::$APP->session->prendiValoreChiave('autenticazione', false) ?
            GruGru::$APP->session->prendiValoreChiave('autenticazione', false)['autenticato']: 
            false;

        if (!$autenticato) {

            if (empty($this->azioni) || in_array(GruGru::$APP->controller->azione, $this->azioni)) {
                throw new NonAutorizzato();
            }
        }
    }

}