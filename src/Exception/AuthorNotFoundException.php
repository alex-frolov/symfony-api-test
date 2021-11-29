<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class AuthorNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Author not found');
    }
}