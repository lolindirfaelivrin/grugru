<?php
declare(strict_types=1);

namespace Libreria;
use Core\Session;

class Flash
{
    private string $chiave_flash;

    private array $messaggi_correnti = [];

    public function __construct(private Session $session, string $chiave_flash = '__grugru_flash')
    {
        $this->chiave_flash = $chiave_flash;

        $this->messaggi_correnti = $this->session->prendiValoreChiave($this->chiave_flash) ?? [];
        $this->session->eliminaChiave($this->chiave_flash);
    }

    public function aggiungi(string $chiave, mixed $valore): void
    {
        $flash = $this->session->prendiValoreChiave($this->chiave_flash) ?? [];
        $flash[$chiave][] = htmlspecialchars($valore);
        $this->session->aggiungiChiaveValore($this->chiave_flash, $flash);
        $this->messaggi_correnti[$chiave][] = $valore;
    }

    public function mostra(string $chiave): array
    {

        if (isset($this->messaggi_correnti[$chiave])) {
            $messaggi = $this->messaggi_correnti[$chiave];
            unset($this->messaggi_correnti[$chiave]);

            return $messaggi;
        }

        return [];
    }

    public function mostraTutti(): array
    {
        $tutti = $this->messaggi_correnti;
        $this->messaggi_correnti = []; // Svuota dopo la lettura
        return $tutti;
    }
}