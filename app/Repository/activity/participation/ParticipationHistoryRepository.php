<?php
declare(strict_types=1);

namespace App\Repository\Activity\Participation;

use PDO;
use Exception;

class ParticipationHistoryRepository implements ParticipationHistoryRepositoryInterface{

    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getParticipationActivityById($activityId){}

}