<?php

declare(strict_types=1);

namespace App\Model;

use OpenApi\Annotations as SWG;

class Book
{
    /**
     * @SWG\Property(description="Идентификатор")
     */
    private int $id;

    /**
     * @SWG\Property(description="Название", example="My First Book")
     */
    private string $name;

    /**
     * @SWG\Property(description="Автор", example="My author")
     */
    private string $author;

    public function __construct(int $id, string $name, string $author)
    {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }
}