<?php

namespace Core;

class Config
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;

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