<?php
declare(strict_types=1);

namespace App\Repository\Activity\Participation;

use PDO;
use Exception;

class ParticipationRepository implements ParticipationRepositoryInterface{

    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getPDO(){
        return $this->dbConnection;
    }

    //###############
    //Defaults
    public function getParticipationById($activityId){}

}