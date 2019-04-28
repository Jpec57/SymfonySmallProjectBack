<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Service\ArticleService;
use AppBundle\Service\DatabaseService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    private $articleService;


    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService){
        $this->articleService = $articleService;
    }

    /**
     * @Route("/blog/articles/{id}", name="view", requirements={"id"="\d+"}, methods={"GET"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showArticleAction($id)
    {
        try {
            $article = $this->articleService->showArticle($id);
        } catch (\Exception $e) {
            return new JsonResponse("An error occurred during the fetching of the article: ".$e->getMessage(), 500);
        }
        return new JsonResponse($article);
    }

    /**
     * @Route("/blog/articles", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createArticleAction(Request $request){
        $article = new Article();
        $article->setTitle($request->get('title', null));
        $article->setDescription($request->get('description', null));

        $validator = $this->get('validator');
        $errors = $validator->validate($article);

        if (count($errors) > 0){
            throw new BadRequestHttpException();
        }
        try {
            $article = $this->articleService->createArticle($article);
        } catch (\Exception $e) {
            return new JsonResponse("An error occurred during the creation of the article: ".$e->getMessage(), 500);

        }
        return new JsonResponse($article);
    }
}
