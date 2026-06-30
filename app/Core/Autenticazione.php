<?php

namespace Core;
use Core\Database\Database;
use Libreria\Log\Log;

class Autenticazione
{
    private string $id;
    private string $email;
    private bool $autenticato = false;
    private string $tabellaUtente = 'utente';

    private const string DUMMY_HASH = '$2y$10$abcdefghijklmnopqrstuuABCDEFGHIJKLMNOPQRSTUVWXYZ01234';

    public function __construct(private Session $session, private Database $database)
    {
        $this->tabellaUtente = GruGru::$APP->configurazione->ottieni('tabella_utente');
    }

    public function autentica(string $email, string $password): bool
    {
        $ip = $this->ipAnonimizzato();

        $sql = "SELECT id, email, password FROM {$this->tabellaUtente} WHERE email = :email";

        $this->database->query($sql);
        $this->database->bind(':email', $email);

        $utente = $this->database->singleRow();
        $hash = $utente->password ?? self::DUMMY_HASH;

        if ($utente && password_verify($password, $hash)) {
            $this->id = $utente->id;
            $this->email = $utente->email;
            $this->autenticato = true;


            if (password_needs_rehash($hash, PASSWORD_BCRYPT)) {
                $nuovoHash = password_hash($password, PASSWORD_BCRYPT);

                $nuovaPasswordSql = "UPDATE {$this->tabellaUtente} SET password = :nuovoHash WHERE email = :email";
                $this->database->query($nuovaPasswordSql);
                $this->database->bind(':nuovoHash', $nuovoHash);
                $this->database->bind(':email', $email);
                $this->database->executeQuery();
            }

            $this->accedi();
            return true;
        }


        Log::errore("Autenticazione fallita", [
            'email_hash' => hash('sha256', mb_strtolower(trim($email))),
            'ip' => $ip,
            'tempo' => time(),
        ]);


        return false;

    }
    public function esci()
    {
        $this->session->eliminaChiave('autenticazione');
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 3600,
                $p['path'],
                $p['domain'],
                $p['secure'],
                $p['httponly']
            );
        }

        session_destroy();
    }

    private function accedi()
    {
        session_regenerate_id(true);
        $this->session->aggiungiChiaveValore('autenticazione', [
            'autenticato' => true,
            'id' => $this->id,
            'email' => $this->email
        ]);
    }

    public function autenticato(): bool
    {
        return $this->session->prendiValoreChiave('autenticazione')['autenticato'] ?? false;
    }

    public function utentId(): string
    {
        /**
         * Se la chiave id non esiste in sessione (es. sessione scaduta), il metodo genera un TypeError perché tenta di restituire null come string. Aggiungere un controllo esplicito.
         */
        return $this->session->prendiValoreChiave('autenticazione')['id']
            ?? throw new \RuntimeException('Utente non autenticato.');
    }

    public function utenteEmail(): string
    {
        return $this->session->prendiValoreChiave('autenticazione')['email'] ?? '';
    }

    private function ipAnonimizzato(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'sconosciuto';

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return preg_replace('/\.\d+$/', '.0', $ip);
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $parti = explode(':', $ip);
            return implode(':', \array_slice($parti, 0, 3)) . '::/48';
        }

        return 'sconosciuto';
    }

}