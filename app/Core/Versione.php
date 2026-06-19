<?php

namespace Core;

final class Versione
{
    public const VERSION = '0.12.2';
    public const MAJOR = 0;
    public const MINOR = 12;
    public const PATCH = 1;
    public const EXTRA = '';  // 'alpha', 'beta', 'rc1', ecc.
    public static function versione(): string
    {
        $extra = self::EXTRA ? '-' . self::EXTRA : '';
        return self::VERSION . $extra;
    }
}