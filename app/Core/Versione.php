<?php

namespace Core;

final class Versione
{
    public const string VERSION = '0.12.3';
    public const string EXTRA = 'beta';

    public static function major(): int
    {
        return (int) explode('.', self::VERSION)[0];
    }

    public static function minor(): int
    {
        return (int) explode('.', self::VERSION)[1];
    }

    public static function patch(): int
    {
        return (int) explode('.', self::VERSION)[2];
    }

    public static function full(): string
    {
        $extra = self::EXTRA ? '-' . self::EXTRA : '';
        return self::VERSION . $extra;
    }
}