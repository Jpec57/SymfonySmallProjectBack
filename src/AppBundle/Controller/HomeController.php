<?php

namespace AppBundle\Controller;

use AppBundle\Service\DatabaseService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @var DatabaseService|null
     */
    private $database;

    /**
     * HomeController constructor.
     * @throws \Exception
     */
    public function __construct(){
        $this->database = DatabaseService::Instance()->connectToDatabase();
    }

    /**
     * @Route("/blog/articles", name="home", methods={"GET"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $resultFromQuery = mysqli_query($this->database, 'SELECT * FROM articles ORDER BY creationDate DESC');

        if (!$resultFromQuery) {
            return new JsonResponse('Invalid query: ' . mysqli_error($this->database), 400);
        }
        $articles = array();
        while ($row = $resultFromQuery->fetch_object()) {
            $articles[] = $row;
        }
        return new JsonResponse($articles);
    }
}
