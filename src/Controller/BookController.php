<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\AuthorNotFoundException;
use App\Exception\BookNameEmptyException;
use App\Model\Book;
use App\Repository\AuthorRepository;
use App\Service\BookService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("{_locale<en|ru>}/books/search/{name}", name="bookSearch", methods={"GET"}, locale="en")
     * @SWG\Tag(name="Поиск книги")
     * @SWG\Response(
     *     response=200,
     *     description="Отдает список книг найденых по названию",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Book::class))
     *     )
     * )
     */
    public function bookSearch(Request $request, string $name, BookService $bookService): Response
    {
        return $this->json($bookService->getByName($name, $request->getLocale()));
    }


    /**
     * @Route("/book/create", name="bookCreator", methods={"POST"})
     * @SWG\Tag(name="Добавление книги")
     * @SWG\Response(
     *     response=200,
     *     description="Добавляет новой книги",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Book::class))
     *     )
     * )
     */
    public function bookCreate(Request $request, BookService $bookService, AuthorRepository $authorRepository): Response
    {
        if (!$request->request->has('names') || empty($request->request->get('names'))) {
            throw new BookNameEmptyException();
        }

        if (!$request->request->has('authorId') || empty($request->request->get('authorId'))) {
            throw new AuthorNotFoundException();
        }
        $author = $authorRepository->find((int)$request->request->get('authorId'));
        if (null === $author) {
            throw new AuthorNotFoundException();
        }

        $bookService->create((array) $request->request->get('names'), $author);

        return $this->json($this->getResponceSuccess());
    }

    private function getResponceSuccess()
    {
        return ['status' => 'ok'];
    }
}