<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\BookLocale;
use App\Entity\Locales;
use App\Exception\BookNameEmptyException;
use App\Exception\LocaleNotFoundException;
use App\Model\Book as BookModel;
use App\Repository\BookLocaleRepository;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use App\Service\BookService;
use App\Tests\AbstractTestCase;

class BookServiceTest extends AbstractTestCase
{
    private function createAuthor(): Author
    {
        $author = (new Author())->setName('Test Author');

        $this->setEntityId($author, 1234);

        return $author;
    }

    private function createBook(int $id, Author $author): Book
    {
        $book = (new Book())
            ->setAuthor($author);

        $this->setEntityId($book, $id);

        return $book;
    }

    private function createBookLocale(int $id, Book $book, string $locale): BookLocale
    {
        $bookLocale = (new BookLocale())
            ->setLocale($locale)
            ->setBook($book)
            ->setName('Test');

        $this->setEntityId($bookLocale, $id);

        return $bookLocale;
    }

    private function mapBook(BookLocale $bookLocale): BookModel
    {
        return new BookModel($bookLocale->getBook()->getId(), $bookLocale->getName(), $bookLocale->getBook()->getAuthor()->getName());
    }

    public function testGetByName(): void
    {
        $locale = Locales::EN;

        $author = $this->createAuthor();
        $book = $this->createBook(1234, $author);
        $bookLocale = $this->createBookLocale(11, $book, $locale);

        $bookRepository = $this->createMock(BookRepository::class);

        $bookLocaleRepository = $this->createMock(BookLocaleRepository::class);
        $bookLocaleRepository->expects($this->once())
            ->method('findByNameAndLocale')
            ->with($bookLocale->getName(), $locale)
            ->willReturnCallback(fn () => [$bookLocale]);

        $service = new BookService($bookRepository, $bookLocaleRepository);
        $actual = $service->getByName($bookLocale->getName(), $locale);
        $expected = [$this->mapBook($bookLocale)];

        $this->assertEquals($expected, $actual);
    }

    public function testGetByEmptyName(): void
    {
        $locale = Locales::EN;
        $bookRepository = $this->createMock(BookRepository::class);
        $bookLocaleRepository = $this->createMock(BookLocaleRepository::class);

        $this->expectException(BookNameEmptyException::class);
        $service = new BookService($bookRepository, $bookLocaleRepository);
        $service->getByName(null, $locale);
    }

    public function testCreateWithNotSupportLocale(): void
    {
        $author = $this->createAuthor();
        $names = [
            'me' => 'test',
            'en' => 'test2',
        ];

        $bookRepository = $this->createMock(BookRepository::class);
        $bookLocaleRepository = $this->createMock(BookLocaleRepository::class);

        $this->expectException(LocaleNotFoundException::class);
        $service = new BookService($bookRepository, $bookLocaleRepository);

        $service->create($names, $author);
    }
}