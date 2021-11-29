<?php

declare(strict_types=1);

namespace App\Entity;

class Locales
{
    public const RU = 'ru';
    public const EN = 'en';

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function has(string $type) : bool
    {
        return $type === self::EN || $type === self::RU;
    }
}