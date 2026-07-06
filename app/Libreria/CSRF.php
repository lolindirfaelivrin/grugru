<?php
declare(strict_types=1);
namespace Libreria;

use Core\Enum\ChiaviRiservateSession;
use Core\Session;

class CSRF
{
    private string $gettone;
    private string $gettone_nome = '_gettone';
    private int $durata = 60 * 60 * 24;
    private string $chiave = 'grugru_gettone';

    public function __construct(private Session $session)
    {
    }
    public function genera(int $forza = 32): CSRF
    {
        $this->gettone = bin2hex(random_bytes($forza));

        $this->session->aggiungiChiaveValore(ChiaviRiservateSession::CsrfToken->value, [
            'gettone' => $this->gettone,
            'durata' => $this->durata,
            'aggiunto' => time()
        ]);

        return $this;
    }

    public function nome(string $nome): CSRF
    {
        $this->gettone_nome = $nome ?? '_gettone';

        return $this;
    }

    public function verifica(string $gettone): bool
    {
        if (!$this->session->esisteChiave(ChiaviRiservateSession::CsrfToken->value)) {
            return false;
        }

        $datiGettone = $this->session->prendiValoreChiave(ChiaviRiservateSession::CsrfToken->value);

        if ((time() - $datiGettone['aggiunto']) > $this->durata) {
            return false;
        }

        return hash_equals($_SESSION[$this->chiave]['gettone'], $gettone);
    }

    public function html(): string
    {
        return "<input type='hidden' name='{$this->gettone_nome}' value='{$this->gettone}'>";
    }

}