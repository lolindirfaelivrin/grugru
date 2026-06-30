<?php
declare(strict_types=1);

namespace Libreria\Log;

use Core\GruGru;
use Libreria\Log\LivelloLog;

class Log
{
    private static ?self $istanzaLog = null;
    /**
     * La directory dove è salvato il file di log
     * @var string
     */
    private string $logDir;
    /**
     * Il nome e estensione del file di log
     * @var string
     */
    private string $logFile;

    /**
     * Il percorso con il nome del file
     * @var string
     */
    private string $log;

    private function __construct(string $logFile = 'log.log')
    {
        if (!preg_match('/^[\w\-]+\.log$/', $logFile)) {
            throw new \InvalidArgumentException('Nome file di log non valido.');
        }

        $logDir = GruGru::$ROOTDIR . '/storage/log';
        $this->logFile = $logFile;
        $this->logDir = "{$logDir}/";
        $this->log = "{$this->logDir}{$this->logFile}";

        if (!file_exists($this->logDir)) {
            $this->creaLogFile();
        }

    }

    private static function ottieniIstanzaLog(): self
    {
        if (self::$istanzaLog === null) {
            self::$istanzaLog = new self();
        }

        return self::$istanzaLog;
    }

    /**
     * Scrive il log
     * @param LivelloLog $livello
     * @param string $messaggio
     * @return void
     */
    private function scrivi(LivelloLog $livello, string $messaggio): void
    {
        $messaggio = str_replace(["\n", "\r"], ['\\n', '\\r'], $messaggio);
        $data = date('d.m.Y H:i:s');
        $log = "[{$data} {$livello->value}]: $messaggio \n";
        $risultato = error_log($log, 3, $this->log);

        if ($risultato === false) {
            throw new \RuntimeException('Impossibile scrivere nel file di log.');
        }

    }

    /**
     * Crea il file di log se non esiste
     * @return void
     */
    private function creaLogFile(): void
    {
        if (!is_dir($this->logDir)) {
            $creata = @mkdir($this->logDir, 0750, true);
            if (!$creata && !is_dir($this->logDir)) {
                throw new \RuntimeException("Impossibile creare la directory di log: {$this->logDir}");
            }
        }

        $file = fopen($this->log, 'w');

        if ($file === false) {
            throw new \RuntimeException('Impossibile creare il file di log.');
        }
        fclose($file);
    }

    /**
     * Scrive un messaggio di livello INFORMAZIONE
     * @param string $messaggio
     * @return void
     */
    public static function info(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::INFO, $messaggio, $dati);
    }

    /**
     * Scrive un messaggio di livello ERRORE 
     * @param string $messaggio
     * @return void
     */
    public static function errore(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::ERROR, $messaggio, $dati);
    }
    public static function debug(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::DEBUG, $messaggio, $dati);
    }

    public static function emergenza(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::EMERGENCY, $messaggio, $dati);
    }
    public static function alert(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::ALERT, $messaggio, $dati);
    }
    public static function critico(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::CRITICAL, $messaggio, $dati);
    }

    public static function avviso(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::WARNING, $messaggio, $dati);
    }

    public static function notifica(string $messaggio, ?array $dati = null): void
    {
        self::emettiLog(LivelloLog::NOTICE, $messaggio, $dati);
    }

    private function json(?array $dati = null): string
    {
        if ($dati === null) {
            return '';
        }

        $json = json_encode($dati, JSON_UNESCAPED_UNICODE);

        if ($json === false) {
            throw new \RuntimeException('Errore nella codifica JSON: ' . json_last_error_msg());
        }

        return $json;
    }

    private function formattaMessaggio(string $messaggio, ?array $dati = null): string
    {
        if ($dati === null) {
            return $messaggio;
        }

        $contesto = $this->json($dati);

        return "{$messaggio} | Dati: {$contesto}";
    }

    private static function emettiLog(LivelloLog $livello, string $messaggio, ?array $dati = null): void
    {
        $logIstanza = self::ottieniIstanzaLog();
        $testo = $logIstanza->formattaMessaggio($messaggio, $dati);
        $logIstanza->scrivi($livello, $testo);
    }


}