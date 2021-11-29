<?php

declare(strict_types=1);

namespace App\Model;

use OpenApi\Annotations as SWG;

class Author
{
    /**
     * @SWG\Property(description="Идентификатор")
     */
    private int $id;

    /**
     * @SWG\Property(description="Имя", example="My Name")
     */
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}