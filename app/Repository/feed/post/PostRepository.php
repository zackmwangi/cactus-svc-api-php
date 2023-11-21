<?php
declare(strict_types=1);

namespace App\Repository\Feed\Post;

use PDO;
use Exception;

class FeedPostRepository implements  FeedPostRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }
}