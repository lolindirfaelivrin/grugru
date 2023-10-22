<?php

namespace Core;
use Core\Interface\ContainerInterface;

class Contenitore implements ContainerInterface
{
    public function get(string $id)
    {

    }

    public function has(string $id): bool
    {
        return false;
    }

}