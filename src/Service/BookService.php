<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\BookLocale;
use App\Entity\Locales;
use App\Exception\BookNameEmptyException;
use App\Exception\LocaleNotFoundException;
use App\Repository\AuthorRepository;
use App\Repository\BookLocaleRepository;
use App\Repository\BookRepository;
use App\Entity\Author as AuthorEntity;
use App\Entity\Book as BookEntity;
use App\Entity\BookLocale as BookLocaleEntity;
use App\Model\Book;

class BookService
{
    private BookRepository $bookRepository;
    private BookLocaleRepository $bookLocaleRepository;

    public function __construct(BookRepository $bookRepository, BookLocaleRepository $bookLocaleRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->bookLocaleRepository = $bookLocaleRepository;
    }

    private function mapBook(BookLocaleEntity $entity): Book
    {
        return new Book((int)$entity->getBook()->getId(), $entity->getName(), $entity->getBook()->getAuthor()->getName());
    }

    /**
     * @return Book[]
     * @psalm-return array<Book>
     */
    public function getByName(?string $name, string $locale): array
    {
        if (empty($name)) {
            throw new BookNameEmptyException();
        }

        return array_map(
            [$this, 'mapBook'],
            $this->bookLocaleRepository->findByNameAndLocale($name, $locale)
        );
    }

    public function create(array $names, AuthorEntity $author): void
    {
        foreach ($names as $locale => $name) {
            if (!Locales::has($locale)) {
                throw new LocaleNotFoundException();
            }
        }

        $book = (new BookEntity())->setAuthor($author);
        $this->bookRepository->save($book);

        foreach ($names as $locale => $name) {
            $bookLocale = new BookLocale();
            $bookLocale->setLocale($locale);
            $bookLocale->setBook($book);
            $bookLocale->setName($name);
            $this->bookLocaleRepository->persist($bookLocale);
        }
        $this->bookLocaleRepository->flush();
    }
}