<?php
declare(strict_types=1);

namespace Libreria;
use Core\GruGru;
use DateInterval;
use DateTimeImmutable;
use DateTimeZone;

/**
 * Crono
 *
 * Helper statico per la gestione di data e ora basato su DateTimeImmutable.
 *
 * L'istante "adesso" viene calcolato una sola volta per ciclo di vita del
 * processo e poi mantenuto in cache in {@see Crono::$adesso}: tutte le
 * chiamate successive a {@see Crono::now()} restituiscono lo stesso istante,
 * "congelato" al primo utilizzo. Questo garantisce coerenza all'interno di
 * una singola request, ma va tenuto presente in processi long-running
 * (worker di coda, daemon CLI, ecc.), dove serve chiamare esplicitamente
 * {@see Crono::reset()} per far ripartire il calcolo del tempo reale, oppure
 * {@see Crono::freeze()} per fissare un istante arbitrario (utile nei test).
 *
 * Il fuso orario utilizzato è quello restituito da `config('timezone', 'UTC')`.
 *
 * Convenzione di ritorno adottata da questa versione:
 * - i metodi che rappresentano un "giorno" ({@see Crono::domani()},
 *   {@see Crono::ieri()}, {@see Crono::aggiungi()}, {@see Crono::togli()})
 *   restituiscono sempre un oggetto DateTimeImmutable, per poter essere
 *   ulteriormente manipolati o formattati a piacere;
 * - {@see Crono::oggi()} resta un'eccezione intenzionale e restituisce una
 *   stringa già formattata, per comodità d'uso nei casi più comuni;
 * - per ottenere una stringa formattata da un DateTimeImmutable prodotto da
 *   uno qualsiasi di questi metodi, usare {@see Crono::formatta()}.
 *
 * @package Core
 */
class Crono
{

    /**
     * Istante corrente, calcolato al primo accesso e mantenuto in cache.
     *
     * @var DateTimeImmutable|null
     */
    private static ?DateTimeImmutable $adesso = null;


    /**
     * Restituisce l'istante corrente, calcolandolo al primo accesso e
     * mantenendolo in cache per le chiamate successive (vedi {@see Crono}).
     * Le microsecondi vengono azzerate.
     *
     * @return DateTimeImmutable Istante corrente (cachato).
     */
    public static function now(): DateTimeImmutable
    {
        if (self::$adesso === null) {
            $now = new DateTimeImmutable('now', new DateTimeZone(GruGru::$APP->configurazione->ottieni('timezone', 'UTC')));
            $now = $now->setTimestamp($now->getTimestamp()); // trim microseconds
            self::$adesso = $now;
        }

        return self::$adesso;
    }

    /**
     * Azzera l'istante cachato, forzando {@see Crono::now()} a ricalcolare
     * il tempo reale alla chiamata successiva.
     *
     * Da usare nei processi long-running (worker, daemon) o all'inizio/fine
     * di ogni test per evitare che l'orario resti "congelato" a un valore
     * calcolato in precedenza.
     *
     * @return void
     */
    public static function reset(): void
    {
        self::$adesso = null;
    }

    /**
     * Fissa manualmente l'istante restituito da {@see Crono::now()}.
     *
     * Utile principalmente nei test, per simulare una data/ora specifica
     * senza dipendere dall'orologio di sistema.
     *
     * @param string|DateTimeImmutable $momento Istante da fissare: stringa
     *        parsabile da DateTimeImmutable (es. '2026-01-01 00:00:00') o
     *        un'istanza già pronta di DateTimeImmutable.
     * @return void
     */
    public static function freeze(string|DateTimeImmutable $momento): void
    {
        self::$adesso = $momento instanceof DateTimeImmutable
            ? $momento
            : new DateTimeImmutable($momento, new DateTimeZone(GruGru::$APP->configurazione->ottieni('timezone', 'UTC')));
    }

    /**
     * Formatta un DateTimeImmutable secondo il formato indicato (o quello
     * di default da configurazione). Punto unico di formattazione, usato
     * internamente da {@see Crono::oggi()} e disponibile anche per
     * formattare a piacere i risultati di {@see Crono::domani()},
     * {@see Crono::ieri()}, {@see Crono::aggiungi()} e {@see Crono::togli()}.
     *
     * @param DateTimeImmutable $data Data da formattare.
     * @param string|null $formato Formato accettato da
     *        DateTimeInterface::format(); se omesso viene usato
     *        `GruGru::$APP->configurazione->ottieni('formato_tempo', 'd-m-Y H:i:s')`.
     * @return string Data formattata.
     */
    public static function formatta(DateTimeImmutable $data, ?string $formato = null): string
    {
        return $data->format($formato ?? GruGru::$APP->configurazione->ottieni('formato_tempo', 'd-m-Y H:i:s'));
    }

    /**
     * Restituisce la data odierna a mezzanotte, formattata secondo
     * `GruGru::$APP->configurazione->ottieni('formato_tempo', 'd-m-Y H:i:s')`.
     *
     * @return string Data odierna formattata (componente ora sempre 00:00:00).
     */
    public static function oggi(): string
    {
        return self::formatta(self::now()->setTime(0, 0, 0));
    }

    /**
     * Restituisce l'anno corrente a 4 cifre.
     *
     * @return string Anno corrente (formato 'Y').
     */
    public static function anno(): string
    {
        return self::now()->format('Y');
    }

    /**
     * Restituisce il mese corrente nel formato richiesto.
     *
     * @param string $formato Formato accettato da DateTimeInterface::format(),
     *        di default 'm' (mese numerico a 2 cifre).
     * @return string Mese corrente formattato.
     */
    public static function mese(string $formato = 'm'): string
    {
        return self::now()->format($formato);
    }

    /**
     * Restituisce il giorno del mese corrente, a 2 cifre.
     *
     * @return string Giorno corrente (formato 'd').
     */
    public static function giorno(): string
    {
        return self::now()->format('d');
    }

    /**
     * Restituisce la data di domani a mezzanotte.
     *
     * @return DateTimeImmutable Data di domani (ora impostata a 00:00:00).
     */
    public static function domani(): DateTimeImmutable
    {
        return self::aggiungiGiorni(1)->setTime(0, 0, 0);
    }

    /**
     * Restituisce la data di ieri a mezzanotte.
     *
     * @return DateTimeImmutable Data di ieri (ora impostata a 00:00:00).
     */
    public static function ieri(): DateTimeImmutable
    {
        return self::aggiungiGiorni(-1)->setTime(0, 0, 0);
    }

    /**
     * Aggiunge un numero di giorni all'istante corrente.
     *
     * @param int $giorni Numero di giorni da aggiungere (può essere negativo,
     *        nel qual caso equivale a {@see Crono::togli()}).
     * @return DateTimeImmutable Data risultante. Usare {@see Crono::formatta()}
     *         per ottenerne una rappresentazione testuale.
     */
    public static function aggiungi(int $giorni): DateTimeImmutable
    {
        return self::aggiungiGiorni($giorni);
    }

    /**
     * Sottrae un numero di giorni all'istante corrente.
     *
     * @param int $giorni Numero di giorni da sottrarre (il segno viene
     *        normalizzato internamente, quindi è indifferente passarlo
     *        positivo o negativo).
     * @return DateTimeImmutable Data risultante. Usare {@see Crono::formatta()}
     *         per ottenerne una rappresentazione testuale.
     */
    public static function togli(int $giorni): DateTimeImmutable
    {
        $giorni = (int) abs($giorni) * -1;

        return self::aggiungiGiorni($giorni);
    }

    /**
     * Calcola la differenza in giorni tra due date, con segno.
     *
     * Il risultato è positivo se $fine è successiva a $inizio, negativo
     * se $fine è precedente a $inizio, zero se coincidono.
     *
     * @param string $inizio Data di inizio, parsabile da DateTimeImmutable.
     * @param string $fine Data di fine, parsabile da DateTimeImmutable.
     * @return int Numero di giorni di differenza (con segno).
     *
     * @throws \Exception Se $inizio o $fine non sono stringhe di data valide.
     */
    public static function differenza(string $inizio, string $fine): int
    {
        $inizio = new DateTimeImmutable($inizio);
        $fine = new DateTimeImmutable($fine);

        $intervallo = $inizio->diff($fine);
        $giorni = (int) $intervallo->format('%a');

        return $intervallo->invert ? -$giorni : $giorni;
    }

    /**
     * Aggiunge (o sottrae, se negativo) un numero di giorni all'istante
     * corrente restituito da {@see Crono::now()}.
     *
     * @param int $aggiungi Numero di giorni da aggiungere; se negativo,
     *        i giorni vengono sottratti.
     * @return DateTimeImmutable Data risultante.
     */
    private static function aggiungiGiorni(int $aggiungi): DateTimeImmutable
    {
        if ($aggiungi < 0) {
            $giorni = (int) abs($aggiungi);
            return self::now()->sub(new DateInterval("P{$giorni}D"));
        }

        return self::now()->add(new DateInterval("P{$aggiungi}D"));
    }

}