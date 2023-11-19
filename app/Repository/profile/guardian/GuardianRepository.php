<?php
declare(strict_types=1);

namespace App\Repository\Profile\Guardian;

use PDO;

class GuardianRepository implements GuardianRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addGuardian($uuid){}

    public function getGuardianByUuid($uuid){}

    public function updateGuardian($uuid){}

    public function deleteGuardian($uuid){}

}

