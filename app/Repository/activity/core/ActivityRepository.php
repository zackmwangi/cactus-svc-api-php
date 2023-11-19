<?php
declare(strict_types=1);

namespace App\Repository\Activity\Core;

use PDO;
use Exception;

class ActivityRepository implements ActivityRepositoryInterface{

    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getActivityById($activityId){}

}