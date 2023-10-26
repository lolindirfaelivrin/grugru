<?php

namespace Core;
use Core\Model\Model;

class Autenticazione
{
    private Session $session;
    public function __construct()
    {
        $this->session = new Session();
    }
    public function autentica(Model $model)
    {
        $tabella = $model->getTabella();
        $sql = "SELECT id, email, password FROM {$tabella} WHERE email = :email";
        $model->db->query($sql);

    }
    public function esci()
    {
        $this->session->eliminaChiave('autenticazione');
    }

    public function accedi()
    {
        $this->session->aggiungiChiaveValore('autenticazione', 'true');    
    }

}