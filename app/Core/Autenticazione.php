<?php

namespace Core;
use Core\Database\Database;

class Autenticazione
{
    private string $id;
    private string $email;
    private bool $autenticato = false;
    public function __construct(private Session $session, private Database $database )
    {}
    
    public function autentica(string $email, string $password): bool
    {
        $tabella = (GruGru::$APP->configurazione->ottieni('tabella_utente'));

        $sql = "SELECT id, email, password FROM {$tabella} WHERE email = :email";

        $this->database->query($sql);
        $this->database->bind(':email', $email);

        $utente = $this->database->singleRow();

        if(password_verify($password, $utente->password))
        {
            $this->id = $utente->id;
            $this->email = $utente->email;
            $this->autenticato = true;

            $this->accedi();

            return true;
        }

        return false;

    }
    public function esci()
    {
        $this->session->eliminaChiave('autenticazione');
        session_destroy();
    }

    private function accedi()
    {
        $this->session->aggiungiChiaveValore('autenticazione', [
            'autenticato' => true,
            'id' => $this->id,
            'email' => $this->email
        ]);    
    }

    public function autenticato():bool
    {
        return $this->session->prendiValoreChiave('autenticazione')['autenticato'] ?? false;
    }

    public function utentId(): string
    {
        return $this->session->prendiValoreChiave('autenticazione')['id'];
    }

    public function utenteEmail(): string
    {
        return $this->email;
    }

}