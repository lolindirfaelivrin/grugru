<?php

declare(strict_types=1);

namespace Core\Database\Seed;
use Core\Interface\DatabaseInterface;

abstract class Seeder
{

    public function __construct(private DatabaseInterface $databaseInterface)
    {
        // Initialize any necessary dependencies or configurations here
    }
    abstract public function avvia(): void;

    public function registra(string $seederClass): void
    {
        $seeder = new $seederClass($this->databaseInterface);
        $seeder->avvia();
    }

}