<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Author;
use App\Model\Author as AuthorModel;
use App\Repository\AuthorRepository;
use App\Service\AuthorService;
use App\Tests\AbstractTestCase;
use Doctrine\Common\Collections\Criteria;

class AuthorServiceTest extends AbstractTestCase
{
    private function createAuthor(): Author
    {
        $author = (new Author())->setName('Test Author');

        $this->setEntityId($author, 1234);

        return $author;
    }

    public function testAuthors(): void
    {
        $repository = $this->createMock(AuthorRepository::class);
        $repository->expects($this->once())
            ->method('findBy')
            ->with([], ['name' => Criteria::ASC])
            ->willReturnCallback(fn () => [$this->createAuthor()]);

        $authorService = new AuthorService($repository);
        $authors = $authorService->authors();
        $expectedAuthors = [
            (new AuthorModel(1234, 'Test Author')),
        ];

        $this->assertEquals($expectedAuthors, $authors);
    }
}