<?php

namespace Core;
use Core\Model\Model;

class Autenticazione
{
    private string $id;
    private string $email;
    public function __construct(private Session $session, private Model $model)
    {}
    public function autentica(string $email, string $password): bool
    {
        $tabella = $this->model->getTabella();
        $sql = "SELECT id, email, password FROM {$tabella} WHERE email = :email";

        $this->model->db->query($sql);
        $this->model->db->bind(':email', $email);

        $utente = $this->model->db->singleRow();

        if(password_verify($password, $utente->password))
        {
            $this->id = $utente->id;
            $this->email = $utente->email;

            $this->accedi();

            return true;
        }

        return false;

    }
    public function esci()
    {
        $this->session->eliminaChiave('autenticazione');
    }

    private function accedi()
    {
        $this->session->aggiungiChiaveValore('autenticazione', [
            'id' => $this->id,
            'email' => $this->email
        ]);    
    }

}