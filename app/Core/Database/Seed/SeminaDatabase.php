<?php
declare(strict_types=1);

namespace Core\Database\Seed;

use Core\Database\Seed\Seeder;

class SeminaDatabase extends Seeder
{
    public function avvia(): void
    {
        // Implementation for database seeding
        $this->registra(Seeder::class);
    }
}