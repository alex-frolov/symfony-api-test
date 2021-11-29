<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Author as AuthorModel;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\Criteria;

class AuthorService
{
    private AuthorRepository $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @return AuthorModel[]
     */
    public function authors(): array
    {
        return array_map(
            fn ($author) => new AuthorModel($author->getId(), $author->getName()),
            $this->authorRepository->findBy([], ['name' => Criteria::ASC])
        );
    }

    public function create(string $name): AuthorModel
    {
        $author = (new Author())->setName($name);
        $this->authorRepository->save($author);

        return new AuthorModel($author->getId(), $author->getName());
    }
}