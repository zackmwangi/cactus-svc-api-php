<?php
declare(strict_types=1);

namespace App\Repository\Profile\Identity;

use PDO;

class IdentityRepository implements IdentityRepositoryInterface{
    private $dbConnection;

    public function __construct(PDO $dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function addIdentity($uuid){}

    public function getIdentityByUuid($uuid){}

    public function updateIdentity($uuid){}

    public function deleteIdentity($uuid){}

}

