<?php
declare(strict_types=1);

namespace App\Repository\Profile\Identity\Preference\Activity;

use PDO;

class ActivityPreferenceRepository implements ActivityPreferenceRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addActivity($uuid){}

    public function getActivityByUuid($uuid){}

    public function updateActivity($uuid){}

    public function deleteActivity($uuid){}

}

