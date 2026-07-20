<?php

declare(strict_types=1);

namespace Libreria\Falsifica;

use Libreria\Falsifica\NomiFalsi;
use Libreria\Falsifica\NumeriFalsi;


final class Falsifica
{
    /**
     * Elenco dei provider che espongono i metodi di generazione.
     */
    private static array $fornitori = [
        NomiFalsi::class,
        NumeriFalsi::class,
    ];
    /**
     * Fabbriche personalizzate per i provider che richiedono parametri
     * nel costruttore. Chiave: nome classe, valore: closure che ritorna l'istanza.
     * Esempio futuro:
     *   IndirizziFalsi::class => fn () => new IndirizziFalsi(lingua: 'it_IT'),
     */
    private static array $fabbriche = [];

    /**
     * Cache delle istanze già create, una per fornitore.
     */
    private static array $istanze = [];

    public static function __callstatic(string $metodo, array $argomenti)
    {
        foreach (self::$fornitori as $fornitore) {
            if (method_exists($fornitore, $metodo)) {
                if (!isset(self::$istanze[$fornitore])) {
                    self::$istanze[$fornitore] = self::creaIstanza($fornitore);
                }
                return self::$istanze[$fornitore]->$metodo(...$argomenti);
            }
        }
        throw new \BadMethodCallException("Metodo statico non trovato: $metodo");
    }

    public static function registraFornitore(string $fornitore, ?callable $fabbrica = null): void
    {
        if (!in_array($fornitore, self::$fornitori, true)) {
            self::$fornitori[] = $fornitore;
        }
        if ($fabbrica !== null) {
            self::$fabbriche[$fornitore] = $fabbrica;
        }
    }

    private static function istanza(string $fornitore): object
    {
        if (isset(self::$istanze[$fornitore])) {
            return self::$istanze[$fornitore];
        }

        $istanza = isset(self::$fabbriche[$fornitore])
            ? (self::$fabbriche[$fornitore])()
            : new $fornitore();

        return self::$istanze[$fornitore] = $istanza;
    }
}
