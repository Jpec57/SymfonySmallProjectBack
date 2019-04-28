<?php

namespace AppBundle\Service;

final class DatabaseService
{
    private $link;

    /**
     * @return DatabaseService|null
     */
    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new DatabaseService();
        }
        return $inst;
    }

    /**
     * @return \mysqli
     * @throws \Exception
     */
    public function connectToDatabase(){
        $this->link = mysqli_connect("127.0.0.1", "root", "root", "test");
        if (!$this->link) {
            throw new \Exception("Error while connecting to database: ". mysqli_connect_error(), 500);
        }
        return $this->link;
    }

    public function closeDatabaseConnection(){
        mysqli_close($this->link);
    }


}