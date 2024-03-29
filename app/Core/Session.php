<?php

namespace Core;
class Session
{
    #Rimettera classe ABSTRACT dopo prova

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function esisteChiave(string $chiave): bool
    {
        /*
        Chiave Casi
        1) $_SESSION['chiave]
        2) $_SESSION['chiave']['chiave]

        Identificare chiave
        1) chiave
        2) chiave.chiave

        Uso
        1) $sessione->esisteChiave('chiave');
        2) $sessione->esisteChiave('chiave.connessione');
        */
       $chiavi = explode('.', $chiave);
        return array_key_exists($chiave, $_SESSION);
    }

    public function aggiungiChiaveValore(string|array $chiave, string|array $valore = '')
    {
        if (is_array($chiave))
        {
            foreach ($chiave as $nome => $valore)
            {
                $this->aggiungiChiaveValore($nome, $valore);
            }

            return $this;

        } else {
            $_SESSION[$chiave] = $valore;
            return $this;
        }       
    }

    // ? Modificato valore defaul da null a [] questo perchè ho tipizzato il tipo di ritorno.
    // ! Questa modifica può causare errori in diversi contesti.
    // ! Aggiunto tipo null di ritorno per via di come ho scritto la funzione session()
    // TODO: Valutare riscrittura di questo metodo
    public function prendiValoreChiave(string $chiave, $default = []): string|array|null
    {
        return $_SESSION[$chiave] ?? $default;
    }

    public function eliminaChiave(string $chiave)
    {
        if($this->esisteChiave($chiave))
        {
            unset($_SESSION[$chiave]);
        }
    }

    public function distruggi()
    {
        session_destroy();
    }

    public function __toString()
    {
        $dati = [];
        foreach ($_SESSION as $chiave => $valore) {
            $dati[$chiave] = $valore;

        }
        
        return implode(' ', $dati);
    }
}