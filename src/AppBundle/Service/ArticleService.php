<?php

namespace AppBundle\Service;


use AppBundle\Entity\Article;
use Exception;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ArticleService
{
    private $database;

    /**
     * ArticleController constructor.
     * @throws \Exception
     */
    public function __construct(){
        $this->database = DatabaseService::Instance()->connectToDatabase();
    }

    /**
     * @param $id
     * @return object|\stdClass
     * @throws Exception
     */
    public function showArticle($id){
        if (is_null($stmt = $this->database->prepare("SELECT * FROM articles WHERE id=?"))) {
            throw new Exception($stmt->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $article = $result->fetch_object();
        $stmt->close();
        return $article;
    }

    /**
     * @param Article $article
     * @return Article
     * @throws Exception
     */
    public function createArticle(Article $article){
        $title = $article->getTitle();
        $description = $article->getDescription();
        if (is_null($stmt = $this->database->prepare("INSERT INTO articles (title, creationDate, description)  VALUES (?, CURRENT_TIMESTAMP , ?)"))) {
            throw new Exception($stmt->error);
        }
        $stmt->bind_param("ss", $title, $description);
        $result = $stmt->execute();
        if (!($result)){
            $error = $stmt->error;
            $stmt->close();
            throw new Exception($error);
        }
        $stmt->close();
        return $article;
    }

}