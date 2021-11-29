<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Author;
use App\Service\AuthorService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as SWG;
use App\Exception\AuthorNameEmptyException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/authors", name="authors", methods={"GET"})
     * @SWG\Tag(name="Авторы")
     * @SWG\Response(
     *     response=200,
     *     description="Отдает список авторов",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Author::class))
     *     )
     * )
     */
    public function authors(AuthorService $authorService): Response
    {
        return $this->json($authorService->authors());
    }

    /**
     * @Route("/author/create", name="authorCreator", methods={"POST"})
     * @SWG\Tag(name="Добавление автора")
     * @SWG\Response(
     *     response=200,
     *     description="Добавляет нового автора",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Author::class))
     *     )
     * )
     */
    public function authorCreate(Request $request, AuthorService $authorService): Response
    {
        if (!$request->request->has('name') || empty($request->request->get('name'))) {
            throw new AuthorNameEmptyException();
        }

        return $this->json($authorService->create($request->request->get('name')));
    }
}