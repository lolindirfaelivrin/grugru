<?php
declare(strict_types=1);

namespace Core;

use Libreria\Log\Log;
use Core\Enum\ChiaviRiservateSession;

//TODO: Gestione della dot notation per le chiavi, tramte un TRAIT
class Session
{
    use Trait\GestisceIP;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start([
                'cookie_httponly' => true,
                'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                'cookie_samesite' => 'Lax',
                'use_strict_mode' => true,
            ]);
        }
    }

    public function esisteChiave(string $chiave): bool
    {
        if (ChiaviRiservateSession::isRiservata($chiave)) {
            throw new \InvalidArgumentException("La chiave è riservata e non può essere utilizzata.");
        }
        /*
        Chiave Casi
        1) $_SESSION['chiave]
        2) $_SESSION['chiave']['chiave]

        Uso
        1) $sessione->esisteChiave('chiave');
        2) $sessione->esisteChiave('chiave.connessione');
        */

        if (!str_contains($chiave, '.')) {
            return \array_key_exists($chiave, $_SESSION);
        }

        $chiavi = explode('.', $chiave);

        foreach ($chiavi as $chiave_corrente) {
            if (!\array_key_exists($chiave_corrente, $_SESSION)) {
                return false;
            }
        }
        return true;
    }

    public function aggiungiChiaveValore(string|array $chiave, string|array $valore = ''): Session
    {
        if (ChiaviRiservateSession::isRiservata($chiave)) {
            throw new \InvalidArgumentException("La chiave è riservata e non può essere utilizzata.");
        }

        if (\is_array($chiave)) {
            foreach ($chiave as $nome => $valore) {
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

    public function prendiValoreChiave(string $chiave, mixed $default = null): mixed
    {
        $dati = $_SESSION;

        // Se la chiave non contiene il punto, ritorna il valore diretto
        if (!str_contains($chiave, '.')) {
            return $dati[$chiave] ?? $default;
        }

        // Naviga l'array usando la dot notation
        foreach (explode('.', $chiave) as $segmento) {
            if (!\is_array($dati) || !\array_key_exists($segmento, $dati)) {
                return $default;
            }
            $dati = $dati[$segmento];
        }

        return $dati;
    }

    public function eliminaChiave(string $chiave): void
    {
        if (!$this->esisteChiave($chiave)) {
            return;
        }

        $segmenti = explode('.', $chiave);
        $ultimoSegmento = array_pop($segmenti);
        $dati = &$_SESSION;

        foreach ($segmenti as $segmento) {
            if (!\is_array($dati) || !\array_key_exists($segmento, $dati)) {
                return;
            }
            $dati = &$dati[$segmento];
        }

        unset($dati[$ultimoSegmento]);
    }

    public function distruggi(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 3600,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public function verificaScadenza(int $minutiMaxInattivita = 30): bool
    {
        $timeout = $minutiMaxInattivita * 60;

        if (isset($_SESSION[ChiaviRiservateSession::UltimoAccesso->value])) {
            $tempoInattivo = time() - $_SESSION[ChiaviRiservateSession::UltimoAccesso->value];
            if ($tempoInattivo >= $timeout) {
                $this->distruggi();
                return false; // Sessione scaduta
            }
        }

        $_SESSION[ChiaviRiservateSession::UltimoAccesso->value] = time();
        return true; // Sessione valida
    }

    public function rigenera(bool $elimina_vecchia_sessione = true): bool
    {
        $rigenerato = session_regenerate_id($elimina_vecchia_sessione);

        if (!$rigenerato) {

            Log::errore('Impossibile rigenerare l\'ID di sessione.', [
                'session_id' => session_id(),
                'session_name' => session_name(),
                'session_status' => session_status(),
                'session_save_path' => session_save_path(),
                'session_cookie_params' => session_get_cookie_params(),
                'ip' => $this->ipAnonimizzato($_SERVER['REMOTE_ADDR']),
                'user_agent' => mb_substr($_SERVER['HTTP_USER_AGENT'] ?? 'N/A', 0, 255),
            ]);

            throw new \RuntimeException('Impossibile rigenerare l\'ID di sessione.');
        }

        return $rigenerato;
    }


}