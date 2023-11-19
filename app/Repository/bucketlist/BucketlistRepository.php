<?php
declare(strict_types=1);

namespace App\Repository\Bucketlist;

use PDO;
use Exception;

class BucketlistRepository implements  BucketlistRepositoryInterface{
    private $dbConnection;
    

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }
}