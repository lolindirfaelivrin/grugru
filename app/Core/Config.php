<?php

namespace Core;

final class Config
{
    private array $config;

    public function __construct(
        private readonly string $percorsoConfig,
        private readonly string $percorsoCache,
        private readonly bool $usaCache = true
    ) {
        $this->config = $this->caricaConfigurazione();

    }

    private function caricaConfigurazione(): array
    {
        if ($this->usaCache && is_file($this->percorsoCache)) {
            return require $this->percorsoCache;
        }

        $config = $this->creaConfigurazione();

        if ($this->usaCache) {
            $this->scriviCache($config);
        }

        return $config;
    }

    private function creaConfigurazione(): array
    {
        $configurazione = [];
        $file_configurazione = glob(rtrim($this->percorsoConfig, '/') . '/*.php');

        if ($file_configurazione === false) {
            throw new \RuntimeException("Errore nella lettura dei file di configurazione");
        }

        foreach ($file_configurazione as $file) {
            $nome_file = basename($file, '.php');
            $configurazione[$nome_file] = require $file;
        }

        return $configurazione;
    }

    private function scriviCache(array $config): void
    {
        $contenuto = "<?php\n\nreturn " . var_export($config, true) . ";\n";

        $risultato = file_put_contents($this->percorsoCache, $contenuto, LOCK_EX);

        if ($risultato === false) {
            throw new \RuntimeException("Impossibile scrivere il file di cache della configurazione: {$this->percorsoCache}");
        }
    }
    public function ottieni(string $chiave, mixed $default = null): mixed
    {
        $path = explode('.', $chiave);
        $value = $this->config[array_shift($path)] ?? null;

        if ($value === null) {
            return $default;
        }

        foreach ($path as $key) {
            if (!isset($value[$key])) {
                return $default;
            }

            $value = $value[$key];
        }

        return $value;

    }
}