<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

class AuthorNameEmptyException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Author name is empty');
    }
}