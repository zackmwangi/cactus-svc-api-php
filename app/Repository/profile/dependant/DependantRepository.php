<?php
declare(strict_types=1);

namespace App\Repository\Profile\Dependant;

use PDO;

class DependantRepository implements DependantRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addDependant($uuid){}

    public function getDependantByUuid($uuid){}

    public function updateDependant($uuid){}

    public function deleteDependant($uuid){}

}

