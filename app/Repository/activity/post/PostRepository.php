<?php
declare(strict_types=1);

namespace App\Repository\Activity\Post;

use PDO;
use Exception;

class ActivityPostRepository implements ActivityPostRepositoryInterface{

    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getActivityPostById($activityId){}

}