<?php

namespace Libreria\Validazione;

class Sanitizza
{
    private array $data = [];

    public function esegui(array $richiesta = [])
    {
        foreach ($richiesta as $key => $value)
        {
            $this->data[$key] = trim(strip_tags($value));
        }
    }

    public function tutto(): array
    {
        return $this->data;
    }

    public function get(string $key, $default = null): ?string
    {
        return $this->data[$key] ?? $default;
    }
}