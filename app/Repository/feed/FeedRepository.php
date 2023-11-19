<?php
declare(strict_types=1);

namespace App\Repository\Feed;

use PDO;
use Exception;

class FeedRepository implements  FeedRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }
}