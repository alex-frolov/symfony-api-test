<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class LocaleNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Locale not found');
    }
}